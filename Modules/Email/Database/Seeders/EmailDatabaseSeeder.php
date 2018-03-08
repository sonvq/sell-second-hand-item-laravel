<?php

namespace Modules\Email\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
use Modules\Email\Entities\Email;

class EmailDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
        DB::table('email__emails')->insert([
                [
                    'subject' => 'Your Password Changed in HandShake',
                    'content' => "<p>Dear <strong>[full_name]</strong>,</p>
                                    
                                    <p>Your HandShake Account Password is successfully changed.</p>
                                    
                                    <p>If you did not change your password, please contact us immediately at <a href='mailto:admin@handshake.com?Subject=Contact%20handshake%20Support' target='_top'>admin@handshake.com</a></p>
                                    
                                    <p>Warm regards,<br />
                                    Handshake team</p>",
                    'status' => Email::STATUS_PUBLISH,
                    'type' => Email::TYPE_CHANGE_PASSWORD,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'subject' => 'Reset your Handshake password',
                    'content' => "<p>Dear <strong>[full_name]</strong>,</p>
    
                                        <p>We received a request to reset the password for your HandShake account.</p>
                                        
                                        <p>Please use the link below to set a new password.</p>
                                        
                                        <p>If you did not request a password change, please contact us at <a href='mailto:admin@handshake.com?Subject=Contact%20handshake%20Support' target='_top'>admin@handshake.com</a></p>
                                        
                                        <p>User ID: <strong>[username]</strong><br />
                                        <a href='[reset_link]' target='_blank'>[reset_link]</a></p>
                                        
                                        <p>(If the above link does not work, please copy the full address and paste it into your browser.)</p>
                                        
                                        <p>Warm regards,<br />
                                        Handshake team</p>",
                    'status' => Email::STATUS_PUBLISH,
                    'type' => Email::TYPE_FORGOT_PASSWORD,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'subject' => 'New offer from [offered_by] for [item_title]',
                    'content' => "<p>Dear <strong>[full_name]</strong>,</p>
                                       <p>You have received a new offer for your [item_title].</p>
                                       <p><strong>Offered Price:</strong> [price_currency] [offer_number]</p>
                                       <p><strong>Offered by:</strong> [offered_by]<br></p> <hr>
                                        <p><small>This is automated email. Please use \"HandShake\" App to respond to the above message. <b>Do not reply to this email address.</b><br />
                                        Any feedback or need help? Please contact us <a href='mailto:admin@handshake.com?Subject=Contact%20handshake%20Support' target='_top'>admin@handshake.com</a></small></p>
                                        
                                        <p><em>Warm regards,<br />
                                        Handshake team</em></p>",
                    'status' => Email::STATUS_PUBLISH,
                    'type' => Email::TYPE_NOTIFICATION_EMAIL,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'subject' => 'Your item successfully promoted - [item_title]',
                    'content' => "<p>Dear <strong>[full_name]</strong>,</p>
                                    
                                    <p><b>Thanks for choosing Handshake!</b></p>
                                    
                                    <p>Your promotional item will be shown on the top of the dynamic feed for <b>[promote_days]</b> days from now.<br />
                                    Please refer to the following receipt of your purchase.</p>
                                    
                                    <p>User ID: <strong>[username]</strong><br />
                                    Promotional Item: <strong>[item_title]</strong><br />
                                    Promotional Start Date: <strong>[featured_start_date]</strong><br />
                                    Promotional End Date: <strong>[featured_end_date]</strong></p>
                                    
                                    <p>&nbsp;</p>
                                    
                                    <table style=\"border: none;width:100%; border-spacing: 0;\">
                                        <tbody>
                                            <tr>
                                                <td style=\"width:25%; border: none\">
                                                <p style=\"border: none; padding-left:5px; margin: 0; font-weight:bold\">Bill To</p>
                                    
                                                <p style=\"padding-left:5px; margin: 0;\">[full_name],<br />
                                                [phone_number]<br />
                                                [city], [country]</p>
                                                </td>
                                                <td style=\"width:25%; border: none; \">&nbsp;</td>
                                                <td style=\"width:25%; border: none; \">
                                                <p style=\"border: none; padding-left:5px; margin: 0; font-weight:bold\">Receipt No</p>
                                    
                                                <p style=\"padding-left:5px; margin: 0; font-weight:bold; height: 50px;\">Receipt Date</p>
                                                </td>
                                                <td style=\"width:25%\">
                                                <p style=\"border: none; padding-left:5px;margin: 0\">[receipt_no]</p>
                                    
                                                <p style=\"padding-left:5px; margin: 0; height: 50px;\">[receipt_date]</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                    <p>&nbsp;</p>
                                    
                                    <table style=\"border: 1px solid black;width:100%; border-spacing: 0;\">
                                        <tbody>
                                            <tr>
                                                <td style=\"width:25%; border-left: 1px solid black;\">
                                                <p style=\"border-bottom:1px solid black;padding-left:5px;margin: 0;background-color: #ccc;\">Qty</p>
                                    
                                                <p style=\"padding-left:5px;margin: 0;height: 50px;\">[qty_no]</p>
                                                </td>
                                                <td style=\"width:25%; border-left: 1px solid black;\">
                                                <p style=\"border-bottom:1px solid black;padding-left:5px;margin: 0;background-color: #ccc;\">Description</p>
                                    
                                                <p style=\"padding-left:5px;margin: 0;height: 50px;\">[package_name]</p>
                                                </td>
                                                <td style=\"width:25%; border-left: 1px solid black;\">
                                                <p style=\"border-bottom:1px solid black;padding-left:5px;margin: 0; background-color: #ccc;\">Unit Price</p>
                                    
                                                <p style=\"padding-left:5px;margin: 0;height: 50px;\">[unit_price]</p>
                                                </td>
                                                <td style=\"width:25%; border-left: 1px solid black;\">
                                                <p style=\"border-bottom:1px solid black;padding-left:5px;margin: 0;background-color: #ccc;\">Amount</p>
                                    
                                                <p style=\"padding-left:5px;margin: 0;height: 50px;\">[amount]</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                    <p>&nbsp;</p>
                                    
                                    <p>If you have any queries regarding this purchase, please reach out to Handshake team at<br />
                                    <strong>handshake.ethereal@gmail.com.</strong></p>
                                    
                                    <p>Have fun and happy Handshaking!</p>
                                    
                                    <p>Warm regards,<br />
                                    Handshake team</p>",
                    'status' => Email::STATUS_PUBLISH,
                    'type' => Email::TYPE_PROMOTE_EMAIL,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'subject' => 'Welcome to Handshake [username]',
                    'content' => "<p>Dear <strong>[full_name]</strong>,</p>

                                    <p><b>Welcome to Handshake!</b></p>
                                    
                                    <p>We&#39;re glad to have you in the community! If you&#39;re new to Handshake, this handy guide that we&#39;ve compiled will get you up and running with your first sale (or purchase!) in no time. We&#39;ve also included a couple of tips and tricks to help you get the most out of your Handshake experience.&nbsp;</p>
                                    
                                    <p>User ID: <strong>[username]</strong></p>
                                    
                                    <p>Please click below link to get user guide</p>
                                    
                                    <p>Burmese Version<br>
                                    <a href='https://HandshakeuserguideBurmese.com' target='_blank'>https://HandshakeuserguideBurmese.com</a></p>
                                    
                                    <p>English Version<br>
                                    <a href='https://HandshakeuserguideEnglish.com' target='_blank'>https://HandshakeuserguideEnglish.com</a></p>
                                    
                                    <p>Before you get started, here are our main channels through which you can get updates on Handshake news and events. Follow us to stay in the loop!</p>
                                    
                                    <ul>
                                        <li>Facebook</li>
                                        <li>Twitter</li>
                                        <li>Instagram</li>
                                        <li>YouTube</li>
                                        <li>Mailing List</li>
                                    </ul>
                                    
                                    <p>Have fun and happy Handshaking!</p>
                                    
                                    <p>Warm regards,<br />
                                    Handshake team<br /></p>",
                    'status' => Email::STATUS_PUBLISH,
                    'type' => Email::TYPE_WELCOME_EMAIL,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
            ]
        );
    }
}
