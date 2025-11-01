<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skin911 - Reset Your Password</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f4f4;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f4; padding: 40px 20px;">
        <tr>
            <td align="center">
                <!-- Main Container -->
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 20px; box-shadow: 0 10px 40px rgba(231, 84, 128, 0.15); overflow: hidden;">
                    <!-- Header with Gradient -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #e75480 0%, #ff8fab 100%); padding: 40px 30px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 28px; font-weight: 700;">
                                <span style="font-size: 36px;">🔐</span><br>
                                Reset Your Password
                            </h1>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="font-size: 16px; color: #333333; line-height: 1.6; margin: 0 0 20px 0;">
                                Hello,
                            </p>

                            <p style="font-size: 16px; color: #333333; line-height: 1.6; margin: 0 0 25px 0;">
                                We received a request to reset the password for your <strong>Skin911</strong> account. If you made this request, click the button below to reset your password:
                            </p>

                            <!-- Reset Button -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin: 30px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $url }}"
                                           style="display: inline-block;
                                                  padding: 16px 40px;
                                                  background: linear-gradient(135deg, #e75480 0%, #ff8fab 100%);
                                                  color: #ffffff;
                                                  text-decoration: none;
                                                  border-radius: 30px;
                                                  font-weight: 600;
                                                  font-size: 16px;
                                                  box-shadow: 0 6px 20px rgba(231, 84, 128, 0.3);
                                                  transition: all 0.3s;">
                                            🔑 Reset Password
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="font-size: 14px; color: #666666; line-height: 1.6; margin: 25px 0 20px 0;">
                                This password reset link will expire in <strong>60 minutes</strong>.
                            </p>

                            <p style="font-size: 14px; color: #666666; line-height: 1.6; margin: 0 0 20px 0;">
                                If you did not request a password reset, no further action is required. Your password will remain unchanged.
                            </p>

                            <!-- Security Notice -->
                            <div style="background-color: #ffe8f0; border-radius: 10px; padding: 20px; margin-top: 30px;">
                                <p style="font-size: 13px; color: #721c24; margin: 0; line-height: 1.5;">
                                    <strong>🛡️ Security Tip:</strong> Never share your password with anyone. Skin911 will never ask for your password via email or phone.
                                </p>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8f9fa; padding: 30px; text-align: center; border-top: 1px solid #e9ecef;">
                            <p style="font-size: 14px; color: #666666; margin: 0 0 10px 0;">
                                Best regards,<br>
                                <strong style="color: #e75480;">The Skin911 Team</strong>
                            </p>
                            <p style="font-size: 12px; color: #999999; margin: 0;">
                                © {{ date('Y') }} Skin911. All rights reserved.<br>
                                This is an automated message, please do not reply to this email.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
