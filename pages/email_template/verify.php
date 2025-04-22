<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Your Email</title>
</head>
<body style="margin: 0; padding: 0; background-color: #eef2f5; font-family: Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                    <tr>
                        <td style="background-color: #2e86de; padding: 25px; color: #ffffff; text-align: center; font-size: 22px; font-weight: 600;">
                            Email Confirmation Required
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 25px 30px; color: #333333; font-size: 16px; text-align: center;">
                            Please use the verification code below to confirm your email address.
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 15px 0; text-align: center;">
                            <span style="display: inline-block; background-color:rgb(255, 0, 200); color: #ffffff; font-size: 24px; font-weight: bold; padding: 12px 28px; border-radius: 6px;">
                                {{VERIFICATION_CODE}}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 20px 30px; color: #666666; font-size: 14px; text-align: center;">
                            If you didn’t sign up for this, you can safely ignore this message.
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 30px 30px 30px; text-align: center; font-size: 13px; color: #aaaaaa;">
                            &copy; <?= date('Y') ?> YourAppName. All rights reserved.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>
</html>
