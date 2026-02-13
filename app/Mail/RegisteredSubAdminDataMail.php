<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Users;
use App\Services\WilayahService;

class RegisteredSubAdminDataMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $subjectText;
    public $wilayahData;

    /**
     * Create a new message instance.
     */
    public function __construct(Users $user, $subject = 'Data anda telah didaftarkan dalam RT/RW Terpadu')
    {
        $this->user = $user;
        $this->subjectText = $subject;
        
        // Initialize WilayahService to get region names
        $wilayahService = new WilayahService();
        
        // Fetch region names if codes exist
        $this->wilayahData = [
            'province' => null,
            'regency' => null,
            'district' => null,
            'village' => null,
        ];
        
        if ($user->kodeProvinsi) {
            $provinces = $wilayahService->getProvinces();
            $this->wilayahData['province'] = $this->findRegionName($provinces, $user->kodeProvinsi);
        }
        
        if ($user->kodeKabupaten) {
            $regencies = $wilayahService->getRegencies($user->kodeProvinsi);
            $this->wilayahData['regency'] = $this->findRegionName($regencies, $user->kodeKabupaten);
        }
        
        if ($user->kodeKecamatan) {
            $districts = $wilayahService->getDistricts($user->kodeKabupaten);
            $this->wilayahData['district'] = $this->findRegionName($districts, $user->kodeKecamatan);
        }
        
        if ($user->kodeKelurahan) {
            $villages = $wilayahService->getVillages($user->kodeKecamatan);
            $this->wilayahData['village'] = $this->findRegionName($villages, $user->kodeKelurahan);
        }
    }
    
    /**
     * Find region name by code
     */
    private function findRegionName($regions, $code)
    {
        if (empty($regions)) {
            return null;
        }
        
        foreach ($regions as $region) {
            if (isset($region['id']) && $region['id'] == $code) {
                return $region['name'] ?? null;
            }
            if (isset($region['kode']) && $region['kode'] == $code) {
                return $region['nama'] ?? null;
            }
        }
        
        return null;
    }

    public function build()
    {
        return $this->subject($this->subjectText)
                    ->view('mails.registered-subadmin')
                    ->with([
                        'user' => $this->user,
                    ]);
    }

    // /**
    //  * Get the message envelope.
    //  */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: $this->subjectText,
    //     );
    // }

    // /**
    //  * Get the message content definition.
    //  */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'mails.registered-user',
    //     );
    // }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];
        
        // Add QR code as attachment if it exists
        if ($this->user->qrImage) {
            $filePath = storage_path('app/public/' . $this->user->qrImage);
            
            if (file_exists($filePath)) {
                $fileName = 'QR_Code_' . $this->user->username . '.png';
                
                $attachments[] = \Illuminate\Mail\Mailables\Attachment::fromPath($filePath)
                    ->as($fileName)
                    ->withMime('image/png');
            }
        }
        
        return $attachments;
    }
}
