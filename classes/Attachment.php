<?php

class Attachment
{
    // Function to check if the file type is an image
    private function isImage($type)
    {
        $imageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/webp'];
        return in_array($type, $imageTypes);
    }

    // Function to check if the file type is a document
    private function isDocument($type)
    {
        $documentTypes = ['application/pdf', 'application/msword', 'application/vnd.ms-excel'];
        return in_array($type, $documentTypes);
    }

    // Method to generate attachment preview HTML
    public function generatePreview($attachmentPath, $attachmentType)
    {
        $html = '<div class="attachment-preview">';
        
        if ($this->isImage($attachmentType)) {
            // Display image preview
            $html .= '<img src="uploads/task_attachments/' . $attachmentPath . '" alt="Attachment Preview" class="img-thumbnail">';
        } elseif ($this->isDocument($attachmentType)) {
            // Display document preview using an iframe
           
            $html .= '<iframe src="uploads/task_attachments/' . $attachmentPath. '" width="100%" height="200px" frameborder="0" style="overflow: hidden; overflow-x: hidden; overflow-y: hidden;"></iframe>';

        } else {
            // For other file types, display a generic file icon
            $html .= '<img src="uploads/task_attachments/icon.png" alt="File Icon" class="img-thumbnail">';
        }

        $html .= '</div>';
        return $html;
    }
}

$attachment = new Attachment();

?>
