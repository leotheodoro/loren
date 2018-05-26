<?php

namespace App\Controllers;

use Core\BaseController;
use Core\Validator;
use Core\Redirect;
use App\Models\User;
use Core\Authenticate;

class UserController extends BaseController
{
    use Authenticate;

    private $user;

    public function __construct()
    {
        parent::__construct();
        $this->user = new User;
    }

    public function create()
    {
        $this->setPageTitle('Register');
        return $this->view('user/create', 'layout');
    }

    public function store($request)
    {
        $data = [
            'name' => $request->post->name,
            'email' => $request->post->email,
            'password' => $request->post->password,
        ];

        if(Validator::make($data, $this->user->rulesCreate())){
            return Redirect::route('/user/create');
        }

        $data['password'] = password_hash($request->post->password, PASSWORD_BCRYPT);

        try {
            $this->user->create($data);
            return Redirect::route('/', [
                'success' => ['Usuário criado com sucesso']
            ]);
        } catch (\Exception $e) {
            return Redirect::route('/user/create', [
                'error' => [$e->getMessage()]
            ]);
        }
    }
}