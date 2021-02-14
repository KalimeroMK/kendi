<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\User\Store;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ApiUserController extends Controller
{
    public function register(Store $request): JsonResponse
    {

        /**Store all values of the fields
         */
        $newUser = $request->all();

        /**Create an encrypted password using the hash
         */
        $newUser['password'] = Hash::make($newUser['password']);

        /**Insert a new user in the table
         */
        $user = User::create($newUser);

        /**Create an access token for the user
         */
        $success['token'] = $user->createToken('AppName')->accessToken;
        /**Return success message with token value
         */
        return response()->json(['success' => $success], 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        /**Read the credentials passed by the user
         */
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        /**Check the credentials are valid or not
         */
        if (auth()->attempt($credentials)) {
            /**Store the information of authenticated user
             */
            $user = Auth::user();
            /**Create token for the authenticated user
             */
            $success['token'] = $user->createToken('AppName')->accessToken;
            return response()->json(['success' => $success], 200);
        } else {
            /**Return error message
             */
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        /**Retrieve the information of the authenticated user
         */
        $user = User::whereId($id)->first();
        /** Return user's details
         */
        return response()->json(['success' => $user], 200);
    }

    public function destroy(User $user): JsonResponse
    {
        /**Retrieve the information of the authenticated user
         */
        try {
            $user->delete();
        } catch (\Exception $e) {
        }
        /** Return user's details
         */
        return response()->json(['success' => $user], 200);
    }
}
