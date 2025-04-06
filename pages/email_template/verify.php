<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>

</head>
<body style="background-color: #f4f4f4; margin: 0; padding: 0;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td align="center" style="padding: 20px 0;">
                <table role="presentation" width="100%" max-width="600px" cellspacing="0" cellpadding="0" border="0" style="background: #ffffff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <tr>
                        <td align="center" style="padding: 20px; background: #007bff; color: #ffffff; font-size: 24px; font-weight: bold;">
                            Verify Your Email
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 20px; font-size: 16px; color: #333;">
                            Use the code below to verify your email:
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 20px;">
                            <span style="background: #007bff; color: #ffffff; font-size: 24px; font-weight: bold; padding: 10px 20px; border-radius: 5px;">
                                <strong>{{VERIFICATION_CODE}}</strong>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 10px 20px; font-size: 14px; color: #555;">
                            If you didn’t request this, please ignore this email.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
