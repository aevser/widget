<?php

namespace App\Services\Ticket\Attachment;

use App\Models\Ticket\Ticket;
use Illuminate\Http\UploadedFile;

class TicketAttachmentService
{
    private const string COLLECTION_NAME = 'attachments';
    private const string DISK_NAME = 'public';

    public function addFiles(Ticket $ticket, array $uploadedFiles): void
    {
        foreach ($uploadedFiles as $uploadedFile) {
            $this->addFile(ticket: $ticket, uploadedFile: $uploadedFile);
        }
    }

    public function addFile(Ticket $ticket, UploadedFile $uploadedFile): void
    {
        $ticket->addMedia($uploadedFile)
            ->usingFileName($this->generateName(uploadedFile: $uploadedFile))
            ->toMediaCollection(self::COLLECTION_NAME, self::DISK_NAME);
    }

    private function generateName(UploadedFile $uploadedFile): string
    {
        return uniqid() . '.' . time() . '.' . $uploadedFile->getClientOriginalExtension();
    }
}
