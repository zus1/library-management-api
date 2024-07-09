<?php

namespace App\Console\Commands;

use App\Models\Rental;
use App\Repository\RentalRepository;
use App\Services\Aws\Sns;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class SendRentalExpiredReminderSmsCommand extends Command
{
    private const CHUNK_SIZE = 2;

    public function __construct(
        private RentalRepository $repository,
        private Sns $sns,
    ){
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:rental-expired-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends a sms reminder to clients that their rental is expired';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->repository->handleExpiredRentals(self::CHUNK_SIZE, [$this, 'sendReminder']);

        return 0;
    }

    public function sendReminder(Collection $rentals): void
    {
        $updated = [];
        $alreadySent = [];

        /** @var Rental $rental */
        foreach ($rentals as $rental) {
            if(in_array($this->getAlreadySentEntry($rental), $alreadySent)) {
                $rental->overdue_warning_sent = true;

                $updated[] = $rental;

                continue;
            }

            $rental->overdue_warning_sent = $this->sns->sendSms(
                $rental->client->phone_number,
                config('app.rental.expired_message')
            );

            $alreadySent[] = $this->getAlreadySentEntry($rental);

            $updated[] = $rental;
        }

        Rental::massUpdate($updated);
    }

    private function getAlreadySentEntry(Rental $rental): array
    {
        return [
            'client_id' => $rental->client_id,
            'date' => (new Carbon($rental->expires_at))->format('Y-m-d H'),
        ];
    }
}
