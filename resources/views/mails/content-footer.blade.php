
<tr>
    <td class="footer" style="padding: 0 20px 10px; text-align: center; background-color: #f9f4ef" bgcolor="#F9F4EF" valign="top">
    <table border="0" cellpadding="0" cellspacing="0" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%" width="100%">
        <tbody>
        <tr>
            <td class="three-col" style="text-align: center; font-size: 0; line-height: 0; padding: 0; margin: 0" valign="bottom">
            <!--[if (gte mso 9)|(IE)]>
            <table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td width="200" valign="bottom" align="left" style="padding:0;">
            <![endif]-->
            <div class="column" style="width: 100%; max-width: 200px; display: inline-block; vertical-align: bottom; text-align: left">
                <p style="font-size: 1px; line-height: 1px">&nbsp;</p>
            </div>
            <!--[if (gte mso 9)|(IE)]></td><td width="200" valign="bottom" align="left" style="padding:0;"><![endif]-->
            <div class="column" style="width: 100%; max-width: 200px; display: inline-block; vertical-align: bottom; text-align: left">
                <table border="0" cellpadding="0" cellspacing="0" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt" align="center">
                <tbody>
                    <tr>
                    <td valign="middle" style="padding: 25px 0; text-align: center">
                        <table border="0" cellpadding="0" cellspacing="0" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt" align="center">
                        <tbody>
                            <tr>
                            <td valign="middle" style="text-align: left; padding: 0; width: 30px">
                                <img src="{{ $path }}/img/logo.png" alt="" style="display: inline-block; border: none" width="30" height="30" />
                            </td>
                            <td valign="middle" style="text-align: left; padding: 0">
                                <p style="margin-top: 0; margin-bottom: 0; font-family: 'urw', Arial, Helvetica, sans-serif; font-size: 16px; line-height: 19px; font-weight: 400; text-transform: uppercase; color: #232200">
                                <!--[if (gte mso 9)|(IE)]><font style="font-family: Arial, Helvetica, sans-serif;"><![endif]-->
                                L'école des Futures Mamans
                                <!--[if (gte mso 9)|(IE)]></font><![endif]-->
                                </p>
                            </td>
                            </tr>
                        </tbody>
                        </table>
                    </td>
                    </tr>
                    <tr>
                    <td valign="top" style="padding: 0 0 25px; text-align: center">
                        <p style="margin-top: 0; margin-bottom: 0; font-family: 'urw', Arial, Helvetica, sans-serif; font-size: 12px; line-height: 16px; font-weight: 400; color: #000000">
                        <!--[if (gte mso 9)|(IE)]><font style="font-family: Arial, Helvetica, sans-serif;"><![endif]-->
                        Discover innovative companies and the people behind them.
                        <!--[if (gte mso 9)|(IE)]></font><![endif]-->
                        </p>
                    </td>
                    </tr>
                    @if ($socials = get_field('socials','options'))
                    <tr>
                    <td valign="top" style="padding: 0 0 25px; text-align: center">
                        <table border="0" cellpadding="0" cellspacing="0" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt" align="center">
                        <tbody>
                            <tr>
                            @if ($facebook = $socials['facebook'])
                            <td valign="middle" align="center" style="padding: 0 6px">
                                <a href="{{ $facebook}}" target="_blank" style="text-decoration: none; border: none"><img src="{{ $path }}/img/fb.png" style="display: block; border: none" width="18" height="18" alt="" /></a>
                            </td>
                            @endif
                            @if ($twitter = $socials['twitter'])
                            <td valign="middle" align="center" style="padding: 0 6px">
                                <a href="{{ $twitter }}" target="_blank" style="text-decoration: none; border: none"><img src="{{ $path }}/img/twitter.png" style="display: block; border: none" width="22" height="18" alt="" /></a>
                            </td>
                            @endif
                            @if ($linkedin = $socials['linkedin'])
                            <td valign="middle" align="center" style="padding: 0 6px">
                                <a href="{{ $linkedin }}" target="_blank" style="text-decoration: none; border: none"><img src="{{ $path }}/img/linkedin.png" style="display: block; border: none" width="16" height="17" alt="" /></a>
                            </td>
                            @endif
                            @if ($instagram = $socials['instagram'])
                            <td valign="middle" align="center" style="padding: 0 6px">
                                <a href="{{ $instagram }}" target="_blank" style="text-decoration: none; border: none"><img src="{{ $path }}/img/inst.png" style="display: block; border: none" width="18" height="18" alt="" /></a>
                            </td>
                            @endif
                            </tr>
                        </tbody>
                        </table>
                    </td>
                    </tr>
                    @endif
                    <tr>
                    <td valign="top" style="padding: 0; text-align: center">
                        <p style="margin-top: 0; margin-bottom: 0; font-family: 'Work Sans', Arial, Helvetica, sans-serif; font-size: 12px; line-height: 16px; font-weight: 400; color: #000000">
                        <!--[if (gte mso 9)|(IE)]><font style="font-family: Arial, Helvetica, sans-serif;"><![endif]-->
                        567 Rue, Ville, index 909878<br />{!! sprintf(get_field('copyright','options'),date('Y')) !!}
                        <!--[if (gte mso 9)|(IE)]></font><![endif]-->
                        </p>
                    </td>
                    </tr>
                </tbody>
                </table>
            </div>
            <!--[if (gte mso 9)|(IE)]></td><td width="200" valign="bottom" align="left" style="padding:0;"><![endif]-->
            <div class="column" style="width: 100%; max-width: 200px; display: inline-block; vertical-align: bottom; text-align: left">
                <table border="0" cellpadding="0" cellspacing="0" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt" align="center">
                <tbody>
                    <tr>
                    <td class="footer-links" valign="top" style="padding: 0; text-align: right">
                        <p style="margin-top: 0; margin-bottom: 0; font-family: 'Work Sans', Arial, Helvetica, sans-serif; font-size: 12px; line-height: 16px; font-weight: 400; color: #cb5050">
                        <!--[if (gte mso 9)|(IE)]><font style="font-family: Arial, Helvetica, sans-serif;"><![endif]-->
                        <a href="{{ get_permalink(962) }}" target="_blank" style="border: none; text-decoration: none; outline: none; color: #cb5050">Privacy Policy</a>&nbsp;|&nbsp;<a href="{{ get_permalink(475) }}" target="_blank" style="border: none; text-decoration: none; outline: none; color: #cb5050">Terms of Service</a>
                        <!--[if (gte mso 9)|(IE)]></font><![endif]-->
                        </p>
                    </td>
                    </tr>
                </tbody>
                </table>
            </div>
            <!--[if (gte mso 9)|(IE)]>
            </td></tr></table>
            <![endif]-->
            </td>
        </tr>
        </tbody>
    </table>
    </td>
</tr>