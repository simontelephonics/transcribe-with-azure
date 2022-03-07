# transcribe-with-azure

Use Azure Cognitive Services - Speech Service to add a transcript to your voicemail-to-e-mail delivery.

### Sign up for Azure Speech Service

Go to the Azure Portal, add a new Speech Service, and choose a pricing tier. The free tier gives you 5 hours of audio transcription per month--enough for testing, home use, or perhaps a small business.

<img src="https://user-images.githubusercontent.com/5303782/152031085-157890ac-dbc1-4716-9c73-7a621124a7f4.png" width=400px/>

---

Once the speech service resource has been created, go to the Keys tab and copy one of the keys to the clipboard. This key is entered in the `$apiKey` variable in the PHP script.

<img src="https://user-images.githubusercontent.com/5303782/152031278-53dcfe60-d728-476d-8b18-6b7f58925f4d.png" width=500px/>

---

### Configure FreePBX
#### Script

Put **transcribe.php** in /usr/local/bin and make it readable and executable by the asterisk user.

Change the `$apiKey` variable at the top of the file to the key you copied earlier.

If your Speech Service resource is not in the eastus region (make note of this on the API Keys screen shown above), adjust the `$msSpeechUrl` variable to reflect the correct region.

#### FreePBX voicemail config

Go to Voicemail Admin and edit the e-mail body block. Add `(TRANSCRIPTION)` somewhere in the block. This token will be replaced by the transcription.

<img src="https://user-images.githubusercontent.com/5303782/152031371-f14467b6-0eca-4b73-86cf-10550bc9ec5d.png" width=600px/>

On the same screen, change the Mail Command to point to the script, e.g. `/usr/local/bin/transcribe.php`

**NOTE:** Voicemail attachments must be in "wav" format. 

### Example e-mail with transcript

<img src="https://user-images.githubusercontent.com/5303782/152034023-a75fffbb-3fea-4d13-8468-0d75eb5403aa.png" width=600px/>

