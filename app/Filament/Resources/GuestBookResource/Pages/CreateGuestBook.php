<?php

namespace App\Filament\Resources\GuestBookResource\Pages;

use App\Enum\StatusRequestEnum;
use App\Filament\Resources\GuestBookResource;
use App\Mail\MailableName;
use App\Models\Feedback;
use App\Models\Request;
use Error;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Stmt\TryCatch;

class CreateGuestBook extends CreateRecord
{
    protected static string $resource = GuestBookResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function sendEmailFeedback($email, $subject, $name){
        Mail::to($email)->send(new MailableName($subject, $name));
    }

    protected function handleRecordCreation(array $data): Model
    {
        $record =  static::getModel()::create($data);
        $emailGuest = $record->email;
        $nameGuest = $record->nama_lengkap;
        $messageGuest = "Konfirmasi penilaian Hasil layanan PST BPS Kota Bukittinggi";
        $subjectGuest = "Konfirmasi penilaian Hasil layanan PST BPS Kota Bukittinggi";

        $this->sendEmailFeedback($emailGuest, $subjectGuest, $nameGuest);
        Log::info($record);
        return $record;
    }

    
}
