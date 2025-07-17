<?php

namespace App\Console\Commands;

use App\Models\Company;
use App\Models\MeetingTime;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FollowUpMeetingSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:meeting-remarks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Follow-up and meeting message time schedul';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = now();
        $company = Company::first();

        $followUpTime = $company->follow_up_message_time;
        $meetingTime = $company->meeting_message_time;

        // Calculate the time to send follow-up and meeting reminders
        $followUpDateTime = $now->copy()->addMinutes($followUpTime);
        $meetingDateTime = $now->copy()->addMinutes($meetingTime);

        $meetings = MeetingTime::where('meeting_date', '>=', $now)
            ->where(function ($query) use ($followUpDateTime, $meetingDateTime) {
                $query->where('type', 'followup')
                    ->where('meeting_date', $followUpDateTime)
                    ->orWhere('type', 'meeting')
                    ->where('meeting_date', $meetingDateTime);
            })
            ->get();
        foreach ($meetings as $meeting) {
            // Send meeting remarks (e.g., email)
            $url = $company->url;

            $data = [
                "apiKey" => $company->apikey,
                "contactNumbers" => $company->phone,
                "senderId" => $company->secretkey,
                "textBody" => $meeting->meeting_remarks
            ];

            if (!empty($company->secretkey)) {
                $info = Http::post($url, $data);
            }
        }
    }
}
