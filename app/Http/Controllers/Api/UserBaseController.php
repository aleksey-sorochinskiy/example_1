<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserBaseController extends Controller
{
    /**
     * Auth user profile data
     *
     * @api
     * @link /admin/profile GET
     *
     * @SWG\Get(
     *     path="/admin/profile",
     *     produces={"application/json"},
     *     tags={"admin"},
     *     @SWG\Response(
     *         response="200",
     *         ref="#/definitions/User",
     *         description="Return current user profile"
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         ref="#/definitions/AuthenticationError"
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         ref="#/definitions/AuthorizationError"
     *     )
     * )
     */
    public function index()
    {
        return Auth::user();
    }

    /**
     * Get user profile
     *
     * @api
     * @link /auth/user/{user} GET
     * @link /admin/user/{user} GET
     *
     * @param \App\User $user
     * @return \App\User
     *
     * @SWG\Get(
     *     path="/admin/user/{userId}",
     *     produces={"application/json"},
     *     tags={"admin"},
     *     @SWG\Parameter(
     *         name="userId",
     *         description="User Id",
     *         required=true,
     *         type="integer",
     *         in="path"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         ref="#/definitions/User",
     *         description="Successful getting of user"
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         ref="#/definitions/AuthenticationError"
     *     ),
     *     @SWG\Response(
     *         response="403",
     *         ref="#/definitions/AuthorizationError"
     *     )
     * )
     */
    public function show(User $user)
    {
        return $user;
    }
}
