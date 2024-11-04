<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Email;
use App\Models\Address;
use App\Models\PhoneNumber;

class UserController extends Controller
{
    function addUserform(Request $request) {
        // $data = User::all();
        // dd($data);
        return view('addUserForm');
    }

    function showAllUsers(Request $request) {
        $data = User::all();
        // dd($data);
        return view('showAllUsers', compact('data'));
    }

    // add user to the database
    function submitAddUserForm(Request $request) {
        $validateData = $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'nullable|email|unique:emails,email|required_without:phoneNumber',
            'phoneNumber' => 'nullable|required_without:email',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
        ]);

        try {
            // save the email only if provided
            $email_fk = null;
            if ($request->filled('email')) {
                $email = new Email;
                $email->email = $request->email;
                $email->save();
                $email_fk = $email->id; // get id of saved email
            }
            
            // save the phoneNumber only if provided
            $phoneNumber_fk = null;
            if ($request->filled('phoneNumber')) {
                $phoneNumber = new PhoneNumber;
                $phoneNumber->phone_number = $request->phoneNumber;
                $phoneNumber->save();
                $phoneNumber_fk = $phoneNumber->id; // get id of saved phone_number
            }

            // save data to addresses table
            $address = new Address;
            $address->city = $request->city;
            $address->state = $request->state;
            $address->country = $request->country;
            $address->save();
            $address_fk = $address->id; // get id of saved address

            // then finally save data to users table
            $user = new User;
            $user->full_name = $request->name;
            $user->username = $request->username;
            $user->email_id = $email_fk; // insert foreign key if email was provided or it will be null by default.
            $user->phone_number_id = $phoneNumber_fk; // insert foreign key if phoneNumber was provided or it will be null by default.
            $user->address_id = $address_fk; // insert foreign key of above saved address
            $user->save();

            session()->flash('success', 'User Added Successfully');
            return redirect()->route('showAllUsers');
        
        } catch(QueryException $e) {
            // Check if the error is due to a duplicate entry
            if ($e->errorInfo[1] == 1062) {
                return redirect()->back()->withInput()->withErrors(['email' => 'The email address is already taken. Please use a different one.']);
            } else {
                return redirect()->back()->withErrors(['error' => 'An error occurred while saving the user. Please try again.']);
            }
        }
    }

    // update user details
    // function updateUserDetails(Request $request) {
    //     $validateData = $request->validate([
    //         'name' => 'required',
    //         'username' => 'required',
    //         'email' => 'nullable|email|unique:emails,email|required_without:phoneNumber',
    //         'phoneNumber' => 'nullable|required_without:email',
    //         'city' => 'required',
    //         'state' => 'required',
    //         'country' => 'required',
    //     ]);

    //     $id = base64_decode($request->input('user_id'));
    //     $existingUser = User::findorfail($id);

    //     $existingUserEmail = null;
    //     if ($existingUser->email_id) {
    //         $existingUserEmail = Email::find($existingUser->email_id);
    //     }

    //     $existingUserPhone = null;
    //     if ($existingUser->phone_number_id) {
    //         $existingUserPhone = PhoneNumber::find($existingUser->phone_number_id);
    //     }
        
    //     $existingUserAddress = Address::findorfail($existingUser->address_id);

    //     if($request->filled('email')){
    //         if($existingUserEmail) {
    //             $existingUserEmail->email = $request->email;
    //             $existingUserEmail->save();
    //         }
    //         else {
    //             $email = new Email;
    //             $email->email = $request->email;
    //             $email->save();
    //             $existingUser->email_id = $email->id; // update user's email_id fk
    //         }
    //     }


    //     if($request->filled('phoneNumber')){
    //         if($existingUserPhone) {
    //             $existingUserPhone->phone_number = $request->phoneNumber;
    //             $existingUserPhone->save();
    //         }
    //         else {
    //             $phone = new Phone;
    //             $phone->phone_number = $request->phoneNumber;
    //             $phone->save();
    //             $existingUser->phone_number_id = $phone->id; // update user's phone_number_id fk
    //         }
    //     }

    //     // Update address fields
    //     $existingUserAddress->city = $request->city;
    //     $existingUserAddress->state = $request->state;
    //     $existingUserAddress->country = $request->country;
    //     $existingUserAddress->save();

    //     // Update user fields
    //     $existingUser->full_name = $request->name;
    //     $existingUser->username = $request->username;
    //     $existingUser->save();
        
    //     session()->flash('success', 'User Details Updated');
    //     return redirect()->route('showAllUsers');   
    // }


    function updateUserDetails(Request $request) {
        $id = base64_decode($request->input('user_id'));
        $existingUser = User::findOrFail($id);
    
        // Get the existing email ID for the user if available
        $existingEmailId = $existingUser->email_id ?? null;
    
        $validateData = $request->validate([
            'name' => 'required',
            'username' => 'required',
            // exclude the existing email ID from unique check
            'email' => [
                'nullable',
                'email',
                'required_without:phoneNumber',
                // Use unique rule while excluding the existing email ID from check
                Rule::unique('emails', 'email')->ignore($existingEmailId)
            ],
            'phoneNumber' => 'nullable|required_without:email',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
        ]);
    
        // Only retrieve email if email_id is not null
        $existingUserEmail = $existingEmailId ? Email::find($existingEmailId) : null;
    
        // Retrieve phone number if phone_number_id is not null
        $existingUserPhone = $existingUser->phone_number_id ? PhoneNumber::find($existingUser->phone_number_id) : null;
    
        // Retrieve address, assuming address_id is always present
        $existingUserAddress = Address::findOrFail($existingUser->address_id);
    
        // Update email if provided and handle new email creation if needed
        if ($request->filled('email')) {
            if ($existingUserEmail) {
                $existingUserEmail->email = $request->email;
                $existingUserEmail->save();
            } else {
                // Create new email record if none exists
                $email = new Email;
                $email->email = $request->email;
                $email->save();
                $existingUser->email_id = $email->id; // update user's foreign key
            }
        }
    
        // Update phone number if provided and handle new phone number creation if needed
        if ($request->filled('phoneNumber')) {
            if ($existingUserPhone) {
                $existingUserPhone->phone_number = $request->phoneNumber;
                $existingUserPhone->save();
            } else {
                // Create new phone number record if none exists
                $phoneNumber = new PhoneNumber;
                $phoneNumber->phone_number = $request->phoneNumber;
                $phoneNumber->save();
                $existingUser->phone_number_id = $phoneNumber->id; // update user's foreign key
            }
        }
    
        // Update address fields
        $existingUserAddress->city = $request->city;
        $existingUserAddress->state = $request->state;
        $existingUserAddress->country = $request->country;
        $existingUserAddress->save();
    
        // Update user fields
        $existingUser->full_name = $request->name;
        $existingUser->username = $request->username;
        $existingUser->save();
        
        session()->flash('success', 'User Details Updated');
        return redirect()->route('showAllUsers');   
    }


    function deleteUser($id) {
        $id = base64_decode($id);
        $existingUser = User::findorfail($id);
        
        $existingUser_emailId = $existingUser->email_id; // get email fk of user
        $existingUser_phoneNubmerId = $existingUser->phone_number_id; // get phone fk of user
        $existingUser_addressId = $existingUser->address_id; // get address fk of user

        Email::where('id', $existingUser_emailId)->delete(); // delete email from emails table
        PhoneNumber::where('id', $existingUser_phoneNubmerId)->delete(); // delete phone number from phone_numbers table
        Address::where('id', $existingUser_addressId)->delete(); // delete address from addresses table
        // after deleting any of the above, the user associated with that email/phone/address will get automatically deleted,
        // so we don't need to delete user from the users table, it will give the user not found error.

        session()->flash('success', 'User deleted successfully.');
        return redirect()->route('showAllUsers');
    }
}
