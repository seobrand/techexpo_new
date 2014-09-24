<div id="wrapper"> <?php echo $this->element('employer_tabs', array('cache' => true)); ?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
        
        
          <?php if(!isset($getProfileInfo)){?><h1 class="bluecolor">Purchase Job Postings  </h1>
         
           <div class="testi_description" style="margin:0 0 0 17px;color: #2D2D2D;font-family: Verdana,Geneva,sans-serif;font-size: 12px;">
          <p>Reach thousands of experienced professionals in technology, engineering, intelligence, cyber security, defense &amp; beyond with <strong>TECHEXPO</strong>.</p>

<p>*Please note, when you exhibit at one of our <strong>TECHEXPO</strong> events, your company automatically receives <strong>10 complimentary</strong> job postings per event. </p>

<p>Our cost effective pricing is the best in the industry.  <br />
Each job posting is active for <strong>60 Days !</strong> </p>
</div>
          <?php
		   }else{?><h1 class="bluecolor">Payment Information </h1><?php } ?>
          
          <h1 class="bluecolor"><?php if(!isset($getProfileInfo)){?>
          <span style="font-size:14px;clear:both;margin:10px 0;">Choose Your Plan</span>
          <?php } ?></h1>
          
          
          <div class="content">
            <?php if(!isset($getProfileInfo)){ /*** Job Plan Form Start Here ***/ ?>
            <?php echo $this->Form->create('JobPlan',array('type'=>'post'));?>
            <table class="tableWhd" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="table_hd"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <th width="30%" style="text-align:left">Plan Name</th>
                      <th width="20%" style="text-align:center">Plan Price</th>
					  <th width="30%" style="text-align:center">Jobs Added To Account</th>
                      <th width="20%" style="text-align:center">Select</th>
                    </tr>
                  </table></td>
              </tr>
			  <input name="data[JobPlan][planID]" id="JobPlan_" value="" type="hidden" />
			  <?php
			   foreach($jobplans as $key=>$jobplan){?>
              <tr>
                <td class="table_row jobplan_border_bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td  width="30%" class="normalfont" style="text-align:left"><?php echo $jobplan['Jobplan']['title'];?></td>
                      <td  width="20%" class="normalfont" style="text-align:center">$<?php echo $jobplan['Jobplan']['price'];?></td>
					  <td  width="30%" class="normalfont" style="text-align:center"><?php echo $jobplan['Jobplan']['jobs'];?> Jobs</td>
                      <td  width="20%" class="normalfont last" style="text-align:center">
                      <input name="data[JobPlan][planID]" id="<?php echo $jobplan['Jobplan']['title'];?>" value="<?php echo $jobplan['Jobplan']['id'];?>" type="radio" 
					  <?php if($key==0){ ?>checked="checked" <?php } ?>/>
                      </td>
                    </tr>
                  </table></td>
              </tr>
              <?php } ?>
              <?php if(count($jobplans)==0){?>
              <tr>
                <td class="table_row jobplan_border_bottom" style="padding:10px !important;" align="center">No Jobplan available for this employer.</td>
              </tr>
              <?php }?>
            </table>
             <?php if(count($jobplans)!=0){?>
            <div class="man_resume_footer padding_zero">
              <ul>
                <li class="last"> <?php echo $this->Form->submit('images/buynow.png',array('div'=>false,'name'=>'Submit'));?> </li>
              </ul>
              <div class="clear"></div>
            </div>
                <?php }?>
            
            <?php echo $this->Form->end();?>
            <br/>
            <h4 class="subtitle">Unlimited Job Posting Pricing Options:</h4>


<table width="100%" border="0" class="post-table">
			<tr>
						<td width="40%" valign="middle">6 Month Unlimited Postings</td>
						<td width="60%" valign="middle">$7,500</td>
			</tr>
				<tr>
						<td width="20%" valign="middle">12 Month Unlimited Postings</td>
						<td width="70%" valign="middle">	$12,500</td>
			</tr>
		
</table>

<br />

	

<div class="testi_description" style="color: #2D2D2D;font-family: Verdana,Geneva,sans-serif;font-size: 12px;">
<!--<p><strong>Highlight </strong>your job postings feature - If you have time-sensitive, critical job openings, you can <strong>highlight</strong> those jobs for just $50 per posting. These featured job postings will always be visible near the top of the list when job seekers conduct their searches.</p>-->

<p><strong>For more details on the above opportunities, please call 212.655.4505 ext 225 or email <a href="mailto:NMathew@TechExpoUSA.com">NMathew@TechExpoUSA.com</a> </strong> </p>

</div>
            <?php /**** END OF Plan Form */
			
			}elseif(isset($getProfileInfo) && $plan_price!=''){  /*** Paypal profile information Form ********/ ?>
            <div class="gray_full_top"></div>
			<?php echo $this->Form->create('JobPlan',array('type'=>'post','onsubmit'=>'return checkForm()'));?>
            <div class="gray_full_mid">&nbsp;&nbsp;<h4>Your Billing Information:</h4><br/>
              <ul class="form_list manage_resume_form">
                <li>
                  <label>First Name:</label>
                  <div class="form_rt_col1">
                    <input name="data[JobPlan][first_name]" type="text" class="small_Texfield_new jobplan" id="first_name" />
                  </div>
                </li>
                <li>
                  <label>Last Name:</label>
                  <div class="form_rt_col1">
                    <input name="data[JobPlan][last_name]" type="text" class="small_Texfield_new jobplan" id="last_name" />
                  </div>
                </li>
                <li>
                  <label>Card Type:</label>
                  <div class="form_rt_col1">
                    <div class="even_reg_dropdown">
                      <select class="card_type" name="data[JobPlan][cc_type]" id="card_type">
                        <option value="Visa">Visa</option>
                        <option value="Master Card">Master Card</option>
                        <option value="Discover">Discover</option>
                        <option value="American Express">American Express</option>
                      </select>
                    </div>
                  </div>
                </li>
                <li>
                  <label>Card Number:</label>
                  <div class="form_rt_col1">
                    <input name="data[JobPlan][card_number]" type="text" class="small_Texfield_new jobplan" id="card_number" maxlength="16"/>
                  </div>
                </li>
                <li>
                  <label>Expiration Date:</label>
                  <div class="form_rt_col1">
                    <div class="small_dropdown margin_lf">
                      <select name="data[JobPlan][exp_month][month]" class="exp_date" id="exp_month">
                        <option value="">Month</option>
                        <option value="01">01-January</option>
                        <option value="02">02-February</option>
                        <option value="03">03-March</option>
                        <option value="04">04-April</option>
                        <option value="05">05-May</option>
                        <option value="06">06-June</option>
                        <option value="07">07-July</option>
                        <option value="08">08-August</option>
                        <option value="09">09-September</option>
                        <option value="10">10-October</option>
                        <option value="11">11-November</option>
                        <option value="12">12-December</option>
                      </select>
                    </div><div class="small_dropdown margin_lf margin_lf_20">
                      <select name="data[JobPlan][exp_year][year]" class="exp_year" id="exp_year">
                        <option value="">Year</option>
                        <?php for($i=date('Y');$i<=date('Y')+9;$i++){?>
                        <option value="<?php echo $i?>"><?php echo $i?></option>
                        <?php }?>
                      </select>
                    </div>
                    <div class="clear"></div>
                  </div>
                </li>
                <li>
                  <label>Card Verification Number:</label>
                  <div class="form_rt_col1">
                    <input name="data[JobPlan][cvv_number]" type="text" class="small_Texfield_new jobplan" id="cvv_number" />
                  </div>
                </li>
              </ul>
              <br />
              <h4>Billing Address:</h4>
              <br />
              <ul class="form_list manage_resume_form">
                <li>
                  <label>Address 1:</label>
                  <div class="form_rt_col1">
                     <input name="data[JobPlan][billing_address1]" type="text" class="small_Texfield_new jobplan" id="billing_address" />
                  </div>
                </li>
                <li>
                  <label>Address 2:</label>
                  <div class="form_rt_col1">
                     <input name="data[JobPlan][billing_address2]" type="text" class="small_Texfield_new jobplan"  />
                  </div>
                </li>
                <li>
                  <label>Country:</label>
                  <div class="form_rt_col1">
                    <div class="even_reg_dropdown">
                      <select name="data[JobPlan][paypal_countries_code]" class="card_type" onchange="loadState(this.value)" id="country">
                        <option value="">Select Country</option>
                        <option value="AF">Afghanistan</option>
                        <option value="AX">Aland Islands</option>
                        <option value="AL">Albania</option>
                        <option value="DZ">Algeria</option>
                        <option value="AS">American Samoa</option>
                        <option value="AD">Andorra</option>
                        <option value="AO">Angola</option>
                        <option value="AI">Anguilla</option>
                        <option value="AQ">Antarctica</option>
                        <option value="AG">Antigua and Barbuda</option>
                        <option value="AR">Argentina</option>
                        <option value="AM">Armenia</option>
                        <option value="AW">Aruba</option>
                        <option value="AU">Australia</option>
                        <option value="AT">Austria</option>
                        <option value="AZ">Azerbaijan</option>
                        <option value="BS">Bahamas</option>
                        <option value="BH">Bahrain</option>
                        <option value="BD">Bangladesh</option>
                        <option value="BB">Barbados</option>
                        <option value="BY">Belarus</option>
                        <option value="BE">Belgium</option>
                        <option value="BZ">Belize</option>
                        <option value="BJ">Benin</option>
                        <option value="BM">Bermuda</option>
                        <option value="BT">Bhutan</option>
                        <option value="BO">Bolivia</option>
                        <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                        <option value="BA">Bosnia and Herzegovina</option>
                        <option value="BW">Botswana</option>
                        <option value="BV">Bouvet Island (Bouvetoya)</option>
                        <option value="BR">Brazil</option>
                        <option value="IO">British Indian Ocean Territory (Chagos Archipelago)</option>
                        <option value="VG">British Virgin Islands</option>
                        <option value="BN">Brunei Darussalam</option>
                        <option value="BG">Bulgaria</option>
                        <option value="BF">Burkina Faso</option>
                        <option value="BI">Burundi</option>
                        <option value="KH">Cambodia</option>
                        <option value="CM">Cameroon</option>
                        <option value="CA">Canada</option>
                        <option value="CV">Cape Verde</option>
                        <option value="KY">Cayman Islands</option>
                        <option value="CF">Central African Republic</option>
                        <option value="TD">Chad</option>
                        <option value="CL">Chile</option>
                        <option value="CN">China</option>
                        <option value="CX">Christmas Island</option>
                        <option value="CC">Cocos (Keeling) Islands</option>
                        <option value="CO">Colombia</option>
                        <option value="KM">Comoros</option>
                        <option value="CD">Congo</option>
                        <option value="CG">Congo</option>
                        <option value="CK">Cook Islands</option>
                        <option value="CR">Costa Rica</option>
                        <option value="CI">Cote d'Ivoire</option>
                        <option value="HR">Croatia</option>
                        <option value="CU">Cuba</option>
                        <option value="CW">Curacao</option>
                        <option value="CY">Cyprus</option>
                        <option value="CZ">Czech Republic</option>
                        <option value="DK">Denmark</option>
                        <option value="DJ">Djibouti</option>
                        <option value="DM">Dominica</option>
                        <option value="DO">Dominican Republic</option>
                        <option value="EC">Ecuador</option>
                        <option value="EG">Egypt</option>
                        <option value="SV">El Salvador</option>
                        <option value="GQ">Equatorial Guinea</option>
                        <option value="ER">Eritrea</option>
                        <option value="EE">Estonia</option>
                        <option value="ET">Ethiopia</option>
                        <option value="FK">Falkland Islands (Malvinas)</option>
                        <option value="FO">Faroe Islands</option>
                        <option value="FJ">Fiji</option>
                        <option value="FI">Finland</option>
                        <option value="FR">France</option>
                        <option value="GF">French Guiana</option>
                        <option value="PF">French Polynesia</option>
                        <option value="TF">French Southern Territories</option>
                        <option value="GA">Gabon</option>
                        <option value="GM">Gambia</option>
                        <option value="GE">Georgia</option>
                        <option value="DE">Germany</option>
                        <option value="GH">Ghana</option>
                        <option value="GI">Gibraltar</option>
                        <option value="GR">Greece</option>
                        <option value="GL">Greenland</option>
                        <option value="GD">Grenada</option>
                        <option value="GP">Guadeloupe</option>
                        <option value="GU">Guam</option>
                        <option value="GT">Guatemala</option>
                        <option value="GG">Guernsey</option>
                        <option value="GN">Guinea</option>
                        <option value="GW">Guinea-Bissau</option>
                        <option value="GY">Guyana</option>
                        <option value="HT">Haiti</option>
                        <option value="HM">Heard Island and McDonald Islands</option>
                        <option value="VA">Holy See (Vatican City State)</option>
                        <option value="HN">Honduras</option>
                        <option value="HK">Hong Kong</option>
                        <option value="HU">Hungary</option>
                        <option value="IS">Iceland</option>
                        <option value="IN">India</option>
                        <option value="ID">Indonesia</option>
                        <option value="IR">Iran</option>
                        <option value="IQ">Iraq</option>
                        <option value="IE">Ireland</option>
                        <option value="IM">Isle of Man</option>
                        <option value="IL">Israel</option>
                        <option value="IT">Italy</option>
                        <option value="JM">Jamaica</option>
                        <option value="JP">Japan</option>
                        <option value="JE">Jersey</option>
                        <option value="JO">Jordan</option>
                        <option value="KZ">Kazakhstan</option>
                        <option value="KE">Kenya</option>
                        <option value="KI">Kiribati</option>
                        <option value="KP">Korea</option>
                        <option value="KR">Korea</option>
                        <option value="KW">Kuwait</option>
                        <option value="KG">Kyrgyz Republic</option>
                        <option value="LA">Lao People's Democratic Republic</option>
                        <option value="LV">Latvia</option>
                        <option value="LB">Lebanon</option>
                        <option value="LS">Lesotho</option>
                        <option value="LR">Liberia</option>
                        <option value="LY">Libya</option>
                        <option value="LI">Liechtenstein</option>
                        <option value="LT">Lithuania</option>
                        <option value="LU">Luxembourg</option>
                        <option value="MO">Macao</option>
                        <option value="MK">Macedonia</option>
                        <option value="MG">Madagascar</option>
                        <option value="MW">Malawi</option>
                        <option value="MY">Malaysia</option>
                        <option value="MV">Maldives</option>
                        <option value="ML">Mali</option>
                        <option value="MT">Malta</option>
                        <option value="MH">Marshall Islands</option>
                        <option value="MQ">Martinique</option>
                        <option value="MR">Mauritania</option>
                        <option value="MU">Mauritius</option>
                        <option value="YT">Mayotte</option>
                        <option value="MX">Mexico</option>
                        <option value="FM">Micronesia</option>
                        <option value="MD">Moldova</option>
                        <option value="MC">Monaco</option>
                        <option value="MN">Mongolia</option>
                        <option value="ME">Montenegro</option>
                        <option value="MS">Montserrat</option>
                        <option value="MA">Morocco</option>
                        <option value="MZ">Mozambique</option>
                        <option value="MM">Myanmar</option>
                        <option value="NA">Namibia</option>
                        <option value="NR">Nauru</option>
                        <option value="NP">Nepal</option>
                        <option value="NL">Netherlands</option>
                        <option value="NC">New Caledonia</option>
                        <option value="NZ">New Zealand</option>
                        <option value="NI">Nicaragua</option>
                        <option value="NE">Niger</option>
                        <option value="NG">Nigeria</option>
                        <option value="NU">Niue</option>
                        <option value="NF">Norfolk Island</option>
                        <option value="MP">Northern Mariana Islands</option>
                        <option value="NO">Norway</option>
                        <option value="OM">Oman</option>
                        <option value="PK">Pakistan</option>
                        <option value="PW">Palau</option>
                        <option value="PS">Palestinian Territory</option>
                        <option value="PA">Panama</option>
                        <option value="PG">Papua New Guinea</option>
                        <option value="PY">Paraguay</option>
                        <option value="PE">Peru</option>
                        <option value="PH">Philippines</option>
                        <option value="PN">Pitcairn Islands</option>
                        <option value="PL">Poland</option>
                        <option value="PT">Portugal</option>
                        <option value="PR">Puerto Rico</option>
                        <option value="QA">Qatar</option>
                        <option value="RE">Reunion</option>
                        <option value="RO">Romania</option>
                        <option value="RU">Russian Federation</option>
                        <option value="RW">Rwanda</option>
                        <option value="BL">Saint Barthelemy</option>
                        <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
                        <option value="KN">Saint Kitts and Nevis</option>
                        <option value="LC">Saint Lucia</option>
                        <option value="MF">Saint Martin</option>
                        <option value="PM">Saint Pierre and Miquelon</option>
                        <option value="VC">Saint Vincent and the Grenadines</option>
                        <option value="WS">Samoa</option>
                        <option value="SM">San Marino</option>
                        <option value="ST">Sao Tome and Principe</option>
                        <option value="SA">Saudi Arabia</option>
                        <option value="SN">Senegal</option>
                        <option value="RS">Serbia</option>
                        <option value="SC">Seychelles</option>
                        <option value="SL">Sierra Leone</option>
                        <option value="SG">Singapore</option>
                        <option value="SX">Sint Maarten (Dutch part)</option>
                        <option value="SK">Slovakia (Slovak Republic)</option>
                        <option value="SI">Slovenia</option>
                        <option value="SB">Solomon Islands</option>
                        <option value="SO">Somalia</option>
                        <option value="ZA">South Africa</option>
                        <option value="GS">South Georgia and the South Sandwich Islands</option>
                        <option value="SS">South Sudan</option>
                        <option value="ES">Spain</option>
                        <option value="LK">Sri Lanka</option>
                        <option value="SD">Sudan</option>
                        <option value="SR">Suriname</option>
                        <option value="SJ">Svalbard &amp; Jan Mayen Islands</option>
                        <option value="SZ">Swaziland</option>
                        <option value="SE">Sweden</option>
                        <option value="CH">Switzerland</option>
                        <option value="SY">Syrian Arab Republic</option>
                        <option value="TW">Taiwan</option>
                        <option value="TJ">Tajikistan</option>
                        <option value="TZ">Tanzania</option>
                        <option value="TH">Thailand</option>
                        <option value="TL">Timor-Leste</option>
                        <option value="TG">Togo</option>
                        <option value="TK">Tokelau</option>
                        <option value="TO">Tonga</option>
                        <option value="TT">Trinidad and Tobago</option>
                        <option value="TN">Tunisia</option>
                        <option value="TR">Turkey</option>
                        <option value="TM">Turkmenistan</option>
                        <option value="TC">Turks and Caicos Islands</option>
                        <option value="TV">Tuvalu</option>
                        <option value="UG">Uganda</option>
                        <option value="UA">Ukraine</option>
                        <option value="AE">United Arab Emirates</option>
                        <option value="GB">United Kingdom of Great Britain &amp; Northern Ireland</option>
                        <option value="UM">United States Minor Outlying Islands</option>
                        <option value="US" selected="selected">United States of America</option>
                        <option value="VI">United States Virgin Islands</option>
                        <option value="UY">Uruguay</option>
                        <option value="UZ">Uzbekistan</option>
                        <option value="VU">Vanuatu</option>
                        <option value="VE">Venezuela</option>
                        <option value="VN">Vietnam</option>
                        <option value="WF">Wallis and Futuna</option>
                        <option value="EH">Western Sahara</option>
                        <option value="YE">Yemen</option>
                        <option value="ZM">Zambia</option>
                        <option value="ZW">Zimbabwe</option>
                      </select>
                    </div>
                  </div>
                </li>
                <li>
                  <label>City:</label>
                  <div class="form_rt_col1">
                   <input name="data[JobPlan][city]" type="text" class="small_Texfield_new jobplan" id="city" />
                  </div>
                </li>
                
                <li>
                  <label>State:</label>
                  <div class="form_rt_col1">
                    <div class="even_reg_dropdown" id="state1">
                      <select name="data[JobPlan][state]" class="card_type" id="state_us">
                        <option value="">Select State</option>
                        <option value="AL">Alabama</option>
                        <option value="AK">Alaska</option>
                        <option value="AZ">Arizona</option>
                        <option value="AR">Arkansas</option>
                        <option value="CA">California</option>
                        <option value="CO">Colorado</option>
                        <option value="CT">Connecticut</option>
                        <option value="DE">Delaware</option>
                        <option value="DC">District Of Columbia</option>
                        <option value="FL">Florida</option>
                        <option value="GA">Georgia</option>
                        <option value="HI">Hawaii</option>
                        <option value="ID">Idaho</option>
                        <option value="IL">Illinois</option>
                        <option value="IN">Indiana</option>
                        <option value="IA">Iowa</option>
                        <option value="KS">Kansas</option>
                        <option value="KY">Kentucky</option>
                        <option value="LA">Louisiana</option>
                        <option value="ME">Maine</option>
                        <option value="MD">Maryland</option>
                        <option value="MA">Massachusetts</option>
                        <option value="MI">Michican</option>
                        <option value="MN">Minnesota</option>
                        <option value="MS">Mississippi</option>
                        <option value="MO">Missouri</option>
                        <option value="MT">Montana</option>
                        <option value="NE">Nebraska</option>
                        <option value="NV">Nevada</option>
                        <option value="NH">New Hampshire</option>
                        <option value="NJ">New Jersey</option>
                        <option value="NM">New Mexico</option>
                        <option value="NY">New York</option>
                        <option value="NC">North Carolina</option>
                        <option value="ND">North Dakota</option>
                        <option value="OH">Ohio</option>
                        <option value="OK">Oklahoma</option>
                        <option value="OR">Oregon</option>
                        <option value="PA">Pennsylvania</option>
                        <option value="RI">Rhode Island</option>
                        <option value="SC">South Carolina</option>
                        <option value="SD">South Dakota</option>
                        <option value="TN">Tennessee</option>
                        <option value="TX">Texas</option>
                        <option value="UT">Utah</option>
                        <option value="VT">Vermont</option>
                        <option value="VA">Virginia</option>
                        <option value="WA">Washington</option>
                        <option value="WV">West Virginia</option>
                        <option value="WI">Wisconsin</option>
                        <option value="WY">Wyoming</option>
                      </select>
                    </div>
					<div class="form_rt_col1" id="state2" style="display:none;">
						<input name="data[JobPlan][state_us]" type="text" class="small_Texfield_new jobplan" id="state_other"/>
					</div>
                  </div>
                </li>
                
                <li>
                  <label>Zip Code:</label>
                  <div class="form_rt_col1">
                    <input name="data[JobPlan][zip_code]" type="text" class="small_Texfield_new jobplan" id="zip" maxlength="10" />
                    &nbsp;&nbsp;(5 or 9 digits) </div>
                </li>
                <li>
                  <label>Total Charge:</label>
                  <div class="form_rt_col1"> <h4>$<?php echo $plan_price; ?> USD</h4> </div>
				  <?php // echo $this->Form->input('planprice',array('type'=>'hidden','value'=>$planID));?>
                  <?php echo $this->Form->input('planID',array('type'=>'hidden','value'=>$planID));?>
                  
				  <?php echo $this->Form->input('jobs',array('type'=>'hidden','value'=>$plan_jobs));?>
                </li>
                <li>
                  <label></label>
                  <div class="form_rt_col1"> <a href="search-results-seek.html">
                    <?php echo $this->Form->submit('images/grey_submit.jpg',array('div'=>false,'name'=>'Submit'));?>
                    </a> </div>
                </li>
              </ul>
            </div>
            <?php }	?>
          </div>
        </div>
      </div>
    </div>
    <?php echo $this->element('employer_left_panel', array('cache' => true)); ?>
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> </div>
</div>
<script type="text/javascript">
function checkForm(){
	firstname = document.getElementById('first_name').value;
	lastname = document.getElementById('last_name').value;
	cardnum = document.getElementById('card_number').value;
	exp_month = document.getElementById('exp_month').value;
	exp_year = document.getElementById('exp_year').value;
	cvv_number = document.getElementById('cvv_number').value;
	billing_address = document.getElementById('billing_address').value;
	city = document.getElementById('city').value;
	state = document.getElementById('state_us').value;
	state_other = document.getElementById('state_other').value;
	zip = document.getElementById('zip').value;
	
	err_msg= '';
	err = 0;
	
	if(firstname==''){
		err_msg += 'Please Enter first name\n';
		err++;
	}
	if(lastname==''){
		err_msg += 'Please Enter last name\n';
		err++;
	}
	if(cardnum==''){
		err_msg += 'Please Enter card number\n';
		err++;
	}
	if(exp_month=='' || exp_year==''){
		err_msg += 'Please Enter valid expiry date\n';
		err++;
	}
	if(cvv_number==''){
		err_msg += 'Please Enter CVV number\n';
		err++;
	}
	if(billing_address==''){
		err_msg += 'Please Enter billing address\n';
		err++;
	}
	if(city==''){
		err_msg += 'Please Enter billing city\n';
		err++;
	}
	if(state=='' && state_other==''){
		err_msg += 'Please Enter billing state\n';
		err++;
	}
	if(zip==''){
		err_msg += 'Please Enter Zip Code\n';
		err++;
	}
	
	if(err>0){
		alert(err_msg)
		return false;
	}else{
		return true;
	}
	
	
}
function loadState(country){
	if(country=='US'){
		document.getElementById('state1').style.display='block';
		document.getElementById('state2').style.display='none';
	}else{
		document.getElementById('state2').style.display='block';
		document.getElementById('state1').style.display='none';
	}

}
</script>