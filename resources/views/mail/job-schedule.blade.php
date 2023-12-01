<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%; background-color: #225588; margin: 0; padding: 0; width: 100%;">
   <tr>
      <td align="center" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative;">
         <table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%; margin: 0; padding: 0; width: 100%;">
            <tr>
               <td class="header" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; padding: 25px 0; text-align: center;">

                  <img src="https://www.sword-group.com/wp-content/uploads/2021/04/sword-logo.png" class="logo" alt="Laravel Logo" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; max-width: 100%; border: none; height: 75px; max-height: 75px; width: 200px;">

               </td>
            </tr>

            <!-- Email Body -->
            <tr>
               <td class="body" width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%; background-color: #225588; border-bottom: 1px solid #225588; border-top: 1px solid #225588; margin: 0; padding: 0; width: 100%;">
                  <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" style="max-width:670px; background:#fff; border-radius:3px; -webkit-box-shadow:0 1px 3px 0 rgba(0, 0, 0, 0.16), 0 1px 3px 0 rgba(0, 0, 0, 0.12);-moz-box-shadow:0 1px 3px 0 rgba(0, 0, 0, 0.16), 0 1px 3px 0 rgba(0, 0, 0, 0.12);box-shadow:0 1px 3px 0 rgba(0, 0, 0, 0.16), 0 1px 3px 0 rgba(0, 0, 0, 0.12); padding:0 40px;">
                     <tbody>
                        <tr>
                           <td style="height:40px;">&nbsp;</td>
                        </tr>
                        <!-- Title -->
                        <tr>
                           <td style="padding:0 15px; text-align:center;">
                              <h1 style="color:#3075BA; font-weight:400; margin:0;font-size:32px;">Interview Schedule
                              </h1>
                              <span style="display:inline-block; vertical-align:middle; margin:29px 0 26px; border-bottom:1px solid #cecece; 
                                        width:100px;"></span>
                           </td>
                        </tr>
                        <!-- Details Table -->
                        <tr>
                           <td>
                              <table cellpadding="0" cellspacing="0" style="width: 100%; border: 1px solid #ededed">
                                 <tbody>
                                    <tr>
                                       <td style="padding: 10px; border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%; font-weight:500; color:#171f23de">
                                          Name:</td>
                                       <td style="padding: 10px; border-bottom: 1px solid #ededed; color: rgba(23,31,35,.87);">
                                          {{$js['can_name']}}
                                       </td>
                                    </tr>
                                    <tr>
                                       <td style="padding: 10px; border-bottom: 1px solid #ededed;border-right: 1px solid #ededed; width: 35%; font-weight:500; color:#171f23de">
                                          Round</td>
                                       <td style="padding: 10px; border-bottom: 1px solid #ededed; color: rgba(23,31,35,.87);">
                                           {{$js['round_id']}}
                                           </td>
                                    </tr>
                                    
                                     
                                     
                                    
                                    <tr>
                                       <td style="padding: 10px;border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%;font-weight:500; color:#171f23de">
                                         Date</td>
                                       <td style="padding: 10px; border-bottom: 1px solid #ededed;color: rgba(23,31,35,.87); ">
                                          {{$js['schedule_date']}}
                                       </td>
                                    </tr>

                                   

                                    <tr>
                                       <td style="padding: 10px;border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%;font-weight:500; color:#171f23de">
                                       Interview Type</td>
                                       <td style="padding: 10px;border-bottom: 1px solid #ededed; color: rgba(23,31,35,.87); ">
                                          {{$js['interview_type']}}
                                       </td>
                                    </tr>

                                    @if(isset($js['url']))
                                     <tr>
                                       <td style="padding: 10px; border-bottom: 1px solid #ededed;border-right: 1px solid #ededed; width: 35%;font-weight:500;border-bottom: 1px solid #ededed; color:#171f23de">
                                         URL</td>
                                       <td style="padding: 10px; color: rgba(23,31,35,.87); ">
                                          <a href="{{$js['url']}}" target="_blank">{{$js['url']}}</a>
                                       </td>
                                    </tr>

                                    @endif
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                        
                        <tr>
                           <td style="height:40px;">&nbsp;</td>
                        </tr>
                     </tbody>
                  </table>
               </td>
            </tr>
            <tr>
               <td style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative;">
                  <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px; margin: 0 auto; padding: 0; text-align: center; width: 570px;">
                     <tr>
                        <td class="content-cell" align="center" style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; max-width: 100vw; padding: 32px;">
                           <p style="box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; position: relative; line-height: 1.5em; margin-top: 0; color: #b0adc5; font-size: 12px; text-align: center;">
                              © 2022 Sword HRM. All rights reserved.</p>

                        </td>
                     </tr>
                  </table>
               </td>
            </tr>


         </table>
      </td>
   </tr>
</table>