@php

$path = get_template_directory_uri().'/assets/mails';


$name = '{{ name }}';
$course_title = '{{ course_title }}';
$course_text = '{{ course_text }}';
$course_image = '{{ course_image }}';
$course_link = '{{ course_link }}';

$curr = '{{this}}';
$facts_left_loop_start = '{{#each facts_left}}';
$facts_left_loop_end = '{{/each}}';
$facts_right_loop_start = '{{#each facts_right}}';
$facts_right_loop_end = '{{/each}}';
@endphp
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office" lang="fr">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Page description" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="x-apple-disable-message-reformatting" content="" />
    <meta name="color-scheme" content="light dark" />
    <meta name="supported-color-schemes" content="light dark" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>L'école des Futures Mamans</title>
    <style type="text/css">
      @import url("https://fonts.googleapis.com/css2?family=Work+Sans&amp;display=swap");
      @font-face {
        font-family: "urw";
        src: url("{{ $path }}/fonts/fontsfree-net-zxss.eot");
        src: url("{{ $path }}/fonts/fontsfree-net-zxss.eot?#iefix") format("embedded-opentype"), url("{{ $path }}/fonts/fontsfree-net-zxss.woff2") format("woff2"), url("{{ $path }}/fonts/fontsfree-net-zxss.woff") format("woff"), url("{{ $path }}/fonts/fontsfree-net-zxss.ttf") format("truetype"), url("{{ $path }}/fonts/fontsfree-net-zxss.svg#urwclassicow01-regularregular") format("svg");
        font-weight: normal;
        font-style: normal;
      }
      #outlook a {
        padding: 0;
      }
      .ExternalClass,
      .ReadMsgBody {
        width: 100%;
      }
      .ExternalClass,
      .ExternalClass p,
      .ExternalClass td,
      .ExternalClass div,
      .ExternalClass span,
      .ExternalClass font {
        line-height: 100%;
      }
      div[style*="margin: 14px 0;"],
      div[style*="margin: 16px 0;"] {
        margin: 0 !important;
      }
      a[x-apple-data-detectors] {
        color: inherit !important;
        text-decoration: none !important;
        font-size: inherit !important;
        font-family: inherit !important;
        font-weight: inherit !important;
        line-height: inherit !important;
      }
      u + #body a {
        color: inherit !important;
        text-decoration: none !important;
        font-size: inherit !important;
        font-family: inherit !important;
        font-weight: inherit !important;
        line-height: inherit !important;
      }
      #MessageViewBody a {
        color: inherit !important;
        text-decoration: none !important;
        font-size: inherit !important;
        font-family: inherit !important;
        font-weight: inherit !important;
        line-height: inherit !important;
      }

      @media screen and (max-width: 639px) {
        .two-col .column {
          max-width: 100% !important;
          width: 100% !important;
        }
        .three-col .column {
          max-width: 100% !important;
          width: 100% !important;
        }
        .link-cell {
          padding-left: 0 !important;
          padding-right: 0 !important;
          text-align: center !important;
        }
        .link-cell div {
          text-align: center !important;
        }
        .footer-links {
          text-align: center !important;
          padding-top: 10px !important;
        }
      }
    </style>
    <!--[if gte mso 9]>
      <xml>
        <o:OfficeDocumentSettings>
          <o:AllowPNG />
          <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
      </xml>
    <![endif]-->
  </head>

  <body style="margin: 0; padding: 0; word-spacing: normal; background-color: #ffffff; color: #333">
    <div style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%">
      <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" style="padding: 0">
            <!--[if (gte mso 9)|(IE)]>
            <table width="640" align="center" border="0" cellspacing="0" cellpadding="0"><tr><td width="640" align="center" valign="top">
            <![endif]-->
            <table class="outer" align="center" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; margin: 0 auto; max-width: 640px" width="100%" border="0" cellpadding="0" cellspacing="0">
              <tbody>
                <tr>
                  <td valign="top">
                    <table style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; margin: 0 auto; width: 100%; height: 323px" width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tbody>
                        <tr>
                          <td style="background-image: url({{ $path }}/img/bg7.jpg); height: 323px" background="{{ $path }}/img/bg7.jpg" bgcolor="#ffffff" width="640" height="323" valign="top">
                            <!--[if gte mso 9]>
                            <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="width:640px;height:323px;">
                              <v:fill type="tile" src="{{ $path }}/img/bg7.jpg" color="#ffffff" />
                              <v:textbox inset="0,0,0,0">
                            <![endif]-->
                            <div>
                              <table border="0" cellpadding="0" cellspacing="0" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%" width="100%">
                                <tbody>
                                  <tr>
                                    <td valign="top" align="center" style="padding: 0">
                                      <table border="0" cellpadding="0" cellspacing="0" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 400px" width="400" align="center">
                                        <tbody>
                                          <tr>
                                            <td valign="top" style="padding: 20px 0 40px; text-align: center">
                                              <a href="{{ get_home_url() }}" target="_blank" style="border: none; text-decoration: none"><img class="logo" src="{{ $path }}/img/logo.png" alt="" style="display: inline-block; border: none" width="56" height="56" /></a>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td valign="top" style="padding: 0 0 20px; text-align: center">
                                              <h1 style="margin-top: 0; margin-bottom: 0; font-family: 'urw', Arial, Helvetica, sans-serif; font-size: 24px; line-height: 30px; font-weight: 400; text-transform: uppercase; color: #cb5050">
                                                <!--[if (gte mso 9)|(IE)]><font style="font-family: Arial, Helvetica, sans-serif;"><![endif]-->
                                                Que s’est il passé ?
                                                <!--[if (gte mso 9)|(IE)]></font><![endif]-->
                                              </h1>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td valign="top" style="padding: 0 0 20px; text-align: center">
                                              <p style="margin-top: 0; margin-bottom: 0; margin-left: 30px; margin-right: 30px; font-family: 'Work Sans', Arial, Helvetica, sans-serif; font-size: 18px; line-height: 24px; font-weight: 400; color: #000000">
                                                <!--[if (gte mso 9)|(IE)]><font style="font-family: Arial, Helvetica, sans-serif;"><![endif]-->
                                                Hello {{ $name }}, nous avons remarqué que vous n’avez pas fini votre achat du cours<!--[if (gte mso 9)|(IE)]></font><![endif]-->
                                                <span style="font-family: 'urw', Arial, Helvetica, sans-serif; color: #63331d">
                                                  <!--[if (gte mso 9)|(IE)]><font style="font-family: Arial, Helvetica, sans-serif;"><![endif]-->
                                                  {{ $course_title }}
                                                  <!--[if (gte mso 9)|(IE)]></font><![endif]-->
                                                </span>
                                              </p>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            <!--[if gte mso 9]>
                            </v:textbox></v:rect><![endif]-->
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>

                <tr>
                  <td valign="top" align="center" style="padding: 25px 0">
                    <table border="0" cellpadding="0" cellspacing="0" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 320px" width="320" align="center">
                      <tbody>
                        <tr>
                          <td background="{{ $path }}/img/bg2.jpg" style="background-image: url({{ $path }}/img/bg2.jpg)" bgcolor="#ffffff" width="320" height="56" valign="top">
                            <!--[if gte mso 9]>
                            <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="width:320px;height:56px;">
                            <v:fill type="frame" src="{{ $path }}/img/bg2.jpg" color="#ffffff" />
                            <v:textbox inset="0,0,0,0">
                            <![endif]-->
                            <div>
                              <table border="0" cellpadding="0" cellspacing="0" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 320px" width="320" align="left">
                                <tbody>
                                  <tr>
                                    <td style="text-align: left; vertical-align: middle" width="320" height="56" valign="middle">
                                      <table border="0" cellpadding="0" cellspacing="0" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%" width="100%">
                                        <tbody>
                                          <tr>
                                            <td style="text-align: center; padding: 0 10px">
                                              <h3 style="margin-top: 0; margin-bottom: 0; text-align: center; font-family: 'urw', Arial, Helvetica, sans-serif; font-size: 20px; line-height: 24px; font-weight: 400; color: #63331d">
                                                <!--[if (gte mso 9)|(IE)]><font style="font-family: Arial, Helvetica, sans-serif;"><![endif]-->
                                                Reprendre la commande ?
                                                <!--[if (gte mso 9)|(IE)]></font><![endif]-->
                                              </h3>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
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

                <tr>
                  <td valign="top" align="center" style="padding: 0">
                    <table border="0" cellpadding="0" cellspacing="0" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt" align="center">
                      <tbody>
                        <tr>
                          <td class="three-col" style="text-align: center; font-size: 0; line-height: 0; padding: 0; margin: 0" valign="middle">
                            <!--[if (gte mso 9)|(IE)]><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td width="200" valign="middle" align="left" style="padding:0;"><![endif]-->
                            <div class="column" style="width: 100%; max-width: 200px; display: inline-block; vertical-align: middle; text-align: left">
                              <table border="0" cellpadding="0" cellspacing="0" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%" width="100%">
                                <tbody>
                                  <tr>
                                    <td style="text-align: center; font-size: 0; line-height: 0; padding: 0; margin: 0; padding: 0 10px 25px" valign="middle">
                                      <table border="0" cellpadding="0" cellspacing="0" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 180px" width="180" align="center">
                                        <tbody>
                                          {{ $facts_left_loop_start }}
                                          <tr>
                                            <td valign="top" align="center" style="padding: 4px 5px; background-color: #f7f2ef; border-radius: 1px" bgcolor="#F7F2EF">
                                              <p style="margin-top: 0; margin-bottom: 0; font-family: 'urw', Arial, Helvetica, sans-serif; font-size: 14px; line-height: 17px; font-weight: 400; color: #232120; text-align: center">
                                                <!--[if (gte mso 9)|(IE)]><font style="font-family: Arial, Helvetica, sans-serif;"><![endif]-->
                                                {{ $curr }}
                                                <!--[if (gte mso 9)|(IE)]></font><![endif]-->
                                              </p>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td valign="top" align="center" style="padding: 0; font-size: 1px; line-height: 12px">&nbsp;</td>
                                          </tr>
                                          {{ $facts_left_loop_end }}
                                        </tbody>
                                      </table>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            <!--[if (gte mso 9)|(IE)]></td><td width="200" valign="middle" align="left" style="padding:0;"><![endif]-->
                            <div class="column" style="width: 100%; max-width: 200px; display: inline-block; vertical-align: middle; text-align: left">
                              <table border="0" cellpadding="0" cellspacing="0" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%" width="100%">
                                <tbody>
                                  <tr>
                                    <td style="text-align: center; font-size: 0; line-height: 0; padding: 0; margin: 0; padding: 0 5px 25px" valign="middle">
                                      <table border="0" cellpadding="0" cellspacing="0" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 190px" width="190" align="center">
                                        <tbody>
                                          <tr>
                                            <td background="{{ $course_image }}" style="background-image: url({{ $course_image }})" bgcolor="#9e9e9e" width="190" height="193" valign="top">
                                              <!--[if gte mso 9]>
                                              <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="width:190px;height:193px;">
                                                <v:fill type="frame" src="{{ $path }}/img/img03.jpg" color="#9e9e9e" />
                                                <v:textbox inset="0,0,0,0">
                                              <![endif]-->
                                              <div>
                                                <h3 style="margin-top: 40px; margin-bottom: 10px; margin-left: 10px; margin-right: 10px; text-align: center; font-family: 'urw', Arial, Helvetica, sans-serif; font-size: 16px; line-height: 20px; font-weight: 400; text-transform: uppercase; color: #fff">
                                                  <!--[if (gte mso 9)|(IE)]><font style="font-family: Arial, Helvetica, sans-serif;"><![endif]-->
                                                  {{ $course_title }}
                                                  <!--[if (gte mso 9)|(IE)]></font><![endif]-->
                                                </h3>
                                                <p style="margin-top: 0; margin-bottom: 12px; margin-left: 10px; margin-right: 10px; font-family: 'Work Sans', Arial, Helvetica, sans-serif; font-size: 14px; line-height: 17px; font-weight: 400; color: #fff; text-align: center">
                                                  <!--[if (gte mso 9)|(IE)]><font style="font-family: Arial, Helvetica, sans-serif;"><![endif]-->
                                                  {{ $course_text }}
                                                  <!--[if (gte mso 9)|(IE)]></font><![endif]-->
                                                </p>
                                                <div style="margin: 0; font-family: 'Work Sans', Arial, Helvetica, sans-serif; text-align: center; line-height: 10px">
                                                  <a href="{{ $course_link }}" class="button" target="_blank" style="background-color: #fff; text-decoration: none; letter-spacing: 0.04em; text-transform: uppercase; padding: 4px 15px 5px; color: #232120; font-weight: 400; display: inline-block; font-size: 14px; mso-padding-alt: 0; text-underline-color: #eee1d6; border-radius: 1px">
                                                    <!--[if (gte mso 9)|(IE)]><i style="mso-font-width: -100%; mso-text-raise: 11pt">&nbsp;</i><font style="font-family: Arial, Helvetica, sans-serif;"><![endif]-->
                                                    <span style="mso-text-raise: 5pt">Finaliser l’achat</span>
                                                    <!--[if (gte mso 9)|(IE)]></font><i style="mso-font-width: -100%">&nbsp;</i><![endif]-->
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
                            <!--[if (gte mso 9)|(IE)]></td><td width="200" valign="middle" align="left" style="padding:0;"><![endif]-->
                            <div class="column" style="width: 100%; max-width: 200px; display: inline-block; vertical-align: middle; text-align: left">
                              <table border="0" cellpadding="0" cellspacing="0" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%" width="100%">
                                <tbody>
                                  <tr>
                                    <td style="text-align: center; font-size: 0; line-height: 0; padding: 0; margin: 0; padding: 0 10px 25px" valign="middle">
                                      <table border="0" cellpadding="0" cellspacing="0" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 180px" width="180" align="center">
                                        <tbody>
                                          {{ $facts_right_loop_start }}
                                          <tr>
                                            <td valign="top" align="center" style="padding: 4px 5px; background-color: #f7f2ef; border-radius: 1px" bgcolor="#F7F2EF">
                                              <p style="margin-top: 0; margin-bottom: 0; font-family: 'urw', Arial, Helvetica, sans-serif; font-size: 14px; line-height: 17px; font-weight: 400; color: #232120; text-align: center">
                                                <!--[if (gte mso 9)|(IE)]><font style="font-family: Arial, Helvetica, sans-serif;"><![endif]-->
                                                {{ $curr }}
                                                <!--[if (gte mso 9)|(IE)]></font><![endif]-->
                                              </p>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td valign="top" align="center" style="padding: 0; font-size: 1px; line-height: 12px">&nbsp;</td>
                                          </tr>
                                          {{ $facts_right_loop_end }}
                                        </tbody>
                                      </table>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            <!--[if (gte mso 9)|(IE)]></td></tr></table><![endif]-->
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>

                @include('mails.content-links')

                @include('mails.content-courses')

              </tbody>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td></tr></table>
            <![endif]-->
          </td>
        </tr>
      </table>
      <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" style="padding: 0; background-color: #f9f4ef" bgcolor="#F9F4EF">
            <!--[if (gte mso 9)|(IE)]>
            <table width="640" align="center" border="0" cellspacing="0" cellpadding="0"><tr><td width="640" align="center" valign="top">
            <![endif]-->
            <table class="outer" align="center" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; margin: 0 auto; max-width: 640px" width="100%" border="0" cellpadding="0" cellspacing="0">
              <tbody>

                @include('mails.content-footer')

              </tbody>
            </table>
            <!--[if (gte mso 9)|(IE)]>
            </td></tr></table>
            <![endif]-->
          </td>
        </tr>
      </table>
    </div>
  </body>
</html>

