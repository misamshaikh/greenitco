<?php

namespace App\Jobs;

use App\Mail\BackgroundMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;       // Number of retries
    public $backoff = 10;    // Seconds between retries

    public array $emailData;

    public function __construct(array $emailData)
    {
        $this->emailData = $emailData;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Attempt to send email
            Mail::to($this->emailData['to'])
                ->send(new BackgroundMail($this->emailData));

            // Handle mail driver failure (e.g., SMTP accepts but fails later)
            if (! empty(Mail::failures())) {
                throw new \Exception(
                    'Mail::failures() returned an error for recipient: ' . $this->emailData['to']
                );
            }

        } catch (\Throwable $e) {

            // Mark job as failed (this automatically triggers failed())
            $this->fail($e);
        }
    }

    public function failed(\Throwable $exception): void
    {
        \Log::error('SendEmailJob FAILED', [
            'recipient' => $this->emailData['to'],
            'data'      => $this->emailData,
            'exception' => $exception->getMessage(),
        ]);

    }
}
