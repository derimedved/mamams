
@php

$loop_courses_start = '{{#each courses}}';
$loop_courses_end = '{{/each}}';
$loop_courses_image = '{{image}}';
$loop_courses_name = '{{name}}';
$loop_courses_text = '{{text}}';
$loop_courses_link = '{{link}}';
@endphp
<tr>
    <td valign="top" align="center" style="padding: 29px 10px 16px">
    <h2 style="margin-top: 0; margin-bottom: 0; font-family: 'urw', Arial, Helvetica, sans-serif; font-size: 18px; line-height: 22px; font-weight: 400; text-transform: uppercase; color: #9b847a">
        <!--[if (gte mso 9)|(IE)]><font style="font-family: Arial, Helvetica, sans-serif;"><![endif]-->
        Vous pourriez aussi être intéressée par :
        <!--[if (gte mso 9)|(IE)]></font><![endif]-->
    </h2>
    </td>
</tr>

<tr>
    <td valign="top" align="center" style="padding: 0 10px">
    <table border="0" cellpadding="0" cellspacing="0" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt" align="center">
        <tbody>
        <tr>
            <td class="three-col" style="text-align: center; font-size: 0; line-height: 0; padding: 0; margin: 0" valign="top">
            <!--[if (gte mso 9)|(IE)]><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td width="200" valign="bottom" align="left" style="padding:0;"><![endif]-->
            {{ $loop_courses_start }}
            <!--[if (gte mso 9)|(IE)]></td><td width="200" valign="top" align="left" style="padding:0;"><![endif]-->
            <div class="column" style="width: 100%; max-width: 200px; display: inline-block; vertical-align: top; text-align: left">
                <table border="0" cellpadding="0" cellspacing="0" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%" width="100%">
                <tbody>
                    <tr>
                    <td style="text-align: center; font-size: 0; line-height: 0; padding: 0; margin: 0; padding: 0 5px 31px" valign="top">
                        <table border="0" cellpadding="0" cellspacing="0" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 190px" width="190" align="center">
                        <tbody>
                            <tr>
                            <td background="{{ $loop_courses_image }}" style="background-image: url({{ $loop_courses_image }})" bgcolor="#9e9e9e" width="190" height="193" valign="top">
                                <!--[if gte mso 9]>
                                <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="width:190px;height:193px;">
                                <v:fill type="frame" src="{{ $loop_courses_image }}" color="#9e9e9e" />
                                <v:textbox inset="0,0,0,0">
                                <![endif]-->
                                <div>
                                <h3 style="margin-top: 40px; margin-bottom: 4px; margin-left: 10px; margin-right: 10px; text-align: center; font-family: 'urw', Arial, Helvetica, sans-serif; font-size: 20px; line-height: 24px; font-weight: 400; text-transform: uppercase; color: #fff">
                                    <!--[if (gte mso 9)|(IE)]><font style="font-family: Arial, Helvetica, sans-serif;"><![endif]-->
                                    {{ $loop_courses_name }}
                                    <!--[if (gte mso 9)|(IE)]></font><![endif]-->
                                </h3>
                                <p style="margin-top: 0; margin-bottom: 8px; margin-left: 10px; margin-right: 10px; font-family: 'Work Sans', Arial, Helvetica, sans-serif; font-size: 14px; line-height: 17px; font-weight: 400; color: #fff; text-align: center">
                                    <!--[if (gte mso 9)|(IE)]><font style="font-family: Arial, Helvetica, sans-serif;"><![endif]-->
                                    {{ $loop_courses_text }}
                                    <!--[if (gte mso 9)|(IE)]></font><![endif]-->
                                </p>
                                <div style="margin: 0; font-family: 'Work Sans', Arial, Helvetica, sans-serif; text-align: center; line-height: 10px">
                                    <a href="{{ $loop_courses_link }}" class="button" target="_blank" style="background-color: #fff; text-decoration: none; letter-spacing: 0.04em; text-transform: uppercase; padding: 10px 15px; color: #232120; font-weight: 400; display: inline-block; font-size: 14px; mso-padding-alt: 0; text-underline-color: #eee1d6; border-radius: 1px">
                                    <!--[if (gte mso 9)|(IE)]><i style="letter-spacing: 10px; mso-font-width: -100%; mso-text-raise: 20pt">&nbsp;</i><font style="font-family: Arial, Helvetica, sans-serif;"><![endif]-->
                                    <span style="mso-text-raise: 10pt">Découvrir</span>
                                    <!--[if (gte mso 9)|(IE)]></font><i style="letter-spacing: 10px; mso-font-width: -100%">&nbsp;</i><![endif]-->
                                    </a>
                                </div>
                                </div>
                                <!--[if gte mso 9]>
                                </v:textbox>
                                </v:rect>
                                <![endif]-->
                            </td>
                            </tr>
                        </tbody>
                        </table>
                    </td>
                    </tr>
                </tbody>
                </table>
            </div>
            {{ $loop_courses_end }}
            <!--[if (gte mso 9)|(IE)]></td></tr></table><![endif]-->
            </td>
        </tr>
        </tbody>
    </table>
    </td>
</tr>