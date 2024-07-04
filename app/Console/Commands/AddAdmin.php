<?php

namespace App\Console\Commands;

use App\Const\Role;
use App\Const\Seniority;
use App\Http\Requests\Rules\RegisterRules;
use App\Models\Librarian;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AddAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds administrator account';

    public function __construct(
        private RegisterRules $registerRules,
    ){
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $email = $this->askForInput('Please enter email', 'email');
        $password = $this->askForInput('Pleas enter password', 'password', 'secret');
        $firstName = $this->askForInput('Please enter first name', 'first_name');
        $lastName = $this->askForInput('Please enter surname', 'last_name');
        $dob = $this->askForInput('Please enter your day of birth, format Y-m-d', 'dob');
        $city = $this->askForInput('Please enter your city', 'city');

        $this->makeUser($email, $password, $firstName, $lastName, $dob, $city);

        $this->info('Account successfully created');

        return 0;
    }

    private function askForInput(string $question, string $field, string $method = 'ask')
    {
        $response = '';
        $valid = false;
        while ($valid === false) {
            $response = $this->$method($question);
            $valid = $this->validateInput($field, $response);
        }

        return $response;
    }

    private function validateInput(string $field, ?string $input = ''): bool
    {
        $rules = $this->registerRules->getRules();

        $validator = Validator::make([$field => $input], [$field => $rules[$field]]);

        if($validator->fails()) {
            $this->error($validator->errors()->first());

            return false;
        }

        return true;
    }

    private function makeUser(string $email, string $password, string $firstName, string $lastName, string $dob, string $city = ''): void
    {
        $librarian = new Librarian();
        $librarian->email = $email;
        $librarian->password = Hash::make($password);
        $librarian->first_name = $firstName;
        $librarian->last_name = $lastName;
        $librarian->dob = $dob;
        $librarian->city = $city === '' ? null : $city;
        $librarian->employed_at = fake()->date('Y-m-d');
        $librarian->identifier = random_int(1000, 9999);
        $librarian->social_security_number = fake()->numberBetween(10000000, 99999999);
        $librarian->seniority = Seniority::SENIOR;
        $librarian->roles = [Role::ADMIN];
        $librarian->active = true;

        $librarian->save();
    }
}
