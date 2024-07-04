<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\LibrarianRequest;
use App\Repository\LibrarianRepository;
use Illuminate\Http\JsonResponse;
use Zus1\LaravelAuth\Constant\TokenType;
use Zus1\LaravelAuth\Mail\Send;
use Zus1\LaravelAuth\Mail\VerificationEmail;
use Zus1\Serializer\Facade\Serializer;

class Register
{
    public function __construct(
        private LibrarianRepository $repository,
        private Send $mailer,
    ){
    }

    public function __invoke(LibrarianRequest $request)
    {
        $librarian = $this->repository->register($request->input());

        $this->mailer->send($librarian, VerificationEmail::class, TokenType::USER_VERIFICATION);

        return new JsonResponse(Serializer::normalize($librarian, 'librarian:register'));
    }
}
