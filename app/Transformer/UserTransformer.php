<?php


namespace App\Transformer;


use App\Model\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
        ];
    }
}
