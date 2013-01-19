<div id="criteria">
	<div class="modal_popup" id="modal_q1">
		<p>Click to select one or more</p>
		<img src="<?php echo base_url() ?>assets/images/modals/q1.jpg">
		<div><span>Privately Held - For Profit</span><br>Privately held companies are not subject to the ups and downs of the stock market.  Employees can expect more interaction with executives and more opportunities for increased responsibility. </div>
		<div><span>Publicly Traded - For Profit</span><br>At a public company, there is constant pressure from the stock market to grow revenue.  This constant growth can result in increased headcount, expanded product lines, and opportunites for employees to grow their career.</div>
		<div><span>Government</span><br>The public sector has a reputation for stability and job security, as well as a slower pace than private companies.  There can be a high level of taxpayer scrutiny, so red tape and bureaucratic procedures are common.</div>
		<div><span>Non-Profit</span><br>Non-profits are a good option for people who really want to make a difference in the lives of others.  Compensation and perks may not be as high as for-profit businesses.</div>
	</div>
	
	<div class="content">
		<div id="1" class="questions">
			<div><div class="bulb" onclick="modal('#modal_q1','600','0');"></div>Select the type of companies you want to work for:</div>
			<ul id="co_type">
				<li id="q1a"></li>
				<li id="q1b"></li>
				<li id="q1c"></li>
				<li id="q1d"></li>
			</ul>
			<input type="hidden" name="q1a" value="0" />
			<input type="hidden" name="q1b" value="0" />
			<input type="hidden" name="q1c" value="0" />
			<input type="hidden" name="q1d" value="0" />
		</div>
		<div id="2" class="questions">
			<div><div class="bulb"></div>Select the pace of the company you want to work in:</div>
			<ul id="co_pace">
				<li id="q2a">Slow</li>
				<li id="q2b">Medium</li>
				<li id="q2c">Fast</li>
			</ul>
			<input type="hidden" name="q2a" value="0" />
			<input type="hidden" name="q2b" value="0" />
			<input type="hidden" name="q2c" value="0" />
		</div>
		<div id="3" class="questions">
			<div><div class="bulb"></div>Select the life cycle of the companies you want to work in:</div>
			<div id="co_cycle_header"></div>
			<ul id="co_cycle">
				<li id="q3a"></li>
				<li id="q3b"></li>
				<li id="q3c"></li>
				<li id="q3d"></li>
				<li id="q3e"></li>
			</ul>
			<input type="hidden" name="q3a" value="0" />
			<input type="hidden" name="q3b" value="0" />
			<input type="hidden" name="q3c" value="0" />
			<input type="hidden" name="q3d" value="0" />
			<input type="hidden" name="q3e" value="0" />
		</div>
		<div id="4" class="questions">
			<div><div class="bulb"></div>Rank the following company benefits &amp; perks you find important:</div>
			<div id="benefits_bar"></div>
			<ul id="co_benefits">
				<li id="q4_1"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Training</li>
				<li id="q4_2"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Matching 401(k) Plans</li>
				<li id="q4_3"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Child Care Facilities</li>
				<li id="q4-4"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Health Care</li>
				<li id="q4_5"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Free Meals</li>
				<li id="q4_6"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Profit Sharing</li>
				<li id="q4_7"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Maternity / Paternity Leave</li>
				<li id="q4_8"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Casual Dresscode</li>
				<li id="q4_9"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Paid Overtime</li>
				<li id="q4_10"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Pet Friendly</li>
				<li id="q4_11"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Fitness Facilities / Membership</li>
				<li id="q4_12"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Dependent Care Support</li>
				<li id="q4_13"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Telecommunting / Alternative Work Sites</li>
				<li id="q4_14"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Paid Sabbatical / Paid Time Off</li>
				<li id="q4_15"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Compressed Workweek / Flexible Work Schedule</li>
				<li id="q4_16"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Education Reimbursement</li>
			</ul>
			<input type="hidden" name="q4" value="0" />
			<input type="hidden" name="qFour" value="0" />
		</div>
		<div id="5" class="questions">
			<div><div class="bulb"></div>How important is corporate citizenship to you?</div>
			<div class="sliderSelected"></div>
			<div id="citizenshipSlider" style="background: none; border: none; cursor: pointer;"></div>
			<div class="slider5Markers">
				<ul>
					<li class="right5Marker">Not<br>Important</li>
					<li class="right5Marker">Somewhat Important</li>
					<li class="right5Marker">Important</li>
					<li class="right5Marker">Very Important</li>
					<li>Extremely Important</li>
				</ul>
			</div>
			<input type="hidden" name="q5" value="0" />
		</div>
		<div id="6" class="questions">
			<div><div class="bulb"></div>How much traveling would you like to do for work?</div>
			<div class="sliderSelected"></div>
			<div id="travelSlider" style="background: none; border: none; cursor: pointer;"></div>
			<div class="slider4Markers">
				<ul>
					<li class="right4Marker">None</li>
					<li class="right4Marker">Every<br>3 Months</li>
					<li class="right4Marker">Every<br>Month</li>
					<li>Every<br>Week</li>
				</ul>
			</div>
			<input type="hidden" name="q6" value="0" />
		</div>
		<div id="7" class="questions">
			<div><div class="bulb"></div>How often do you want your roles &amp; responsibilities to change?</div>
			<div class="sliderSelected"></div>
			<div id="roleSlider" style="background: none; border: none; cursor: pointer;"></div>
			<div class="slider4Markers">
				<ul>
					<li class="right4Marker">Every<br>3+ Years</li>
					<li class="right4Marker">Every<br>1-3 Years</li>
					<li class="right4Marker">Every<br>12 Months</li>
					<li>Every<br>6 Months</li>
				</ul>
			</div>
			<input type="hidden" name="q7" value="0" />
		</div>
		<div id="8" class="questions">
			<div><div class="bulb"></div>Rank the following in order of importance for promotion eligibility:</div>
			<div id="promotion_bar"></div>
			<ul id="co_promotion">
				<li id="q8_1"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Business Need</li>
				<li id="q8_2"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Time at Level</li>
				<li id="q8_3"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Skills Qualification</li>
				<li id="q8_4"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Increased Responsibilities</li>
				<li id="q8_5"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Leadership Readiness</li>
				<li id="q8_6"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Job Performance</li>
			</ul>
			<input type="hidden" name="q8" value="0" />
		</div>
		<div id="9" class="questions">
			<div><div class="bulb"></div>Select the work environment you thrive in:</div>
			<div id="envQuestions">
				<div id="q9_1" class="env">
					<div class="envAnswer1">Supportive</div><div class="or">- or -</div><div class="envAnswer2">Independent</div>
				</div>
				<div id="q9_2" class="env">
					<div class="envAnswer1">Customer-Focused</div><div class="or">- or -</div><div class="envAnswer2">Product-Focused</div>
				</div>
				<div id="q9_3" class="env">
					<div class="envAnswer1">Quiet</div><div class="or">- or -</div><div class="envAnswer2">Lively</div>
				</div>
				<div id="q9_4" class="env">
					<div class="envAnswer1">Family Oriented</div><div class="or">- or -</div><div class="envAnswer2">Business Oriented</div>
				</div>
				<div id="q9_5" class="env">
					<div class="envAnswer1">Calm</div><div class="or">- or -</div><div class="envAnswer2">Agressive</div>
				</div>
				<div id="q9_6" class="env">
					<div class="envAnswer1">Planned</div><div class="or">- or -</div><div class="envAnswer2">Adhoc</div>
				</div>
				<div id="q9_7" class="env">
					<div class="envAnswer1">Existing Technology</div><div class="or">- or -</div><div class="envAnswer2">New Technology</div>
				</div>
				<div id="q9_8" class="env">
					<div class="envAnswer1">Open &amp; Transparent</div><div class="or">- or -</div><div class="envAnswer2"> Hidden &amp; Undefined</div>
				</div>
				<div id="q9_9" class="env">
					<div class="envAnswer1">Structured</div><div class="or">- or -</div><div class="envAnswer2">Relaxed</div>
				</div>
				<div id="q9_10" class="env">
					<div class="envAnswer1">High-Profile</div><div class="or">- or -</div><div class="envAnswer2">Low-Key</div>
				</div>
			</div>
			<div id="harveyBall" class="clear">
				<img  id="envProgressOverlay" src="<?php echo base_url() ?>assets/images/imgOverlay.png" alt="progress" usemap="#environmentMap" />
				<map name="environmentMap" id="environmentMap">
					  <area shape="poly" coords="64,62,64,4,82,6,98,15" alt="1 of 10" />
					  <area shape="poly" coords="64,63,99,16,112,28,119,44" alt="2 of 10" />
					  <area shape="poly" coords="64,63,119,45,123,63,119,81" alt="3 of 10" />
					  <area shape="poly" coords="64,63,119,81,111,98,98,110" alt="4 of 10" />
					  <area shape="poly" coords="64,64,98,111,82,120,64,122" alt="5 of 10" />
					  <area shape="poly" coords="63,65,63,122,44,119,29,111" alt="6 of 10" />
					  <area shape="poly" coords="63,63,29,111,15,98,8,81" alt="7 of 10" />
					  <area shape="poly" coords="63,63,8,81,4,63,7,46" alt="8 of 10" />
					  <area shape="poly" coords="63,64,8,46,14,31,27,17" alt="9 of 10" />
					  <area shape="poly" coords="64,63,27,17,44,6,64,4" alt="10 of 10" />
				</map>
			</div>
			<input type="hidden" name="q9_1" value="0" />
			<input type="hidden" name="q9_2" value="0" />
			<input type="hidden" name="q9_3" value="0" />
			<input type="hidden" name="q9_4" value="0" />
			<input type="hidden" name="q9_5" value="0" />
			<input type="hidden" name="q9_6" value="0" />
			<input type="hidden" name="q9_7" value="0" />
			<input type="hidden" name="q9_8" value="0" />
			<input type="hidden" name="q9_9" value="0" />
			<input type="hidden" name="q9_10" value="0" />
		</div>
		<div id="10" class="questions">
			<div><div class="bulb"></div>Rank your most preferred type of recognition for doing exceptional work:</div>
			<div id="recognition_bar"></div>
			<ul id="co_recognition">
				<li id="q10_1"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Team Dinners</li>
				<li id="q10_2"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Informal "Thank You"</li>
				<li id="q10_3"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Salary Compensation</li>
				<li id="q10_4"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Time with Senior Leadership</li>
				<li id="q10_5"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Public Recognition</li>
				<li id="q10_6"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Time Away from Work</li>
			</ul>
			<input type="hidden" name="q10" value="0" />
		</div>
		<div id="11" class="questions">
			<div><div class="bulb"></div>Pick one of the following views on workplace politics:</div>
			<div id="politics" class="clear">
				<img id="politicsOverlay" src="<?php echo base_url() ?>assets/images/imgOverlay.png" alt="cloud" usemap="#politicsCloud" />
				<map name="politicsCloud" id="politicsCloud">
					<area shape="poly" coords="32,72,40,56,61,45,83,43,92,22,110,10,139,5,164,10,181,20,190,33,214,30,238,34,256,45,261,52,288,53,310,63,321,80,317,98,301,111,281,116,263,117,254,140,226,156,199,162,171,161,148,150,126,158,95,156,72,146,61,132,58,123,39,125,20,119,8,104,7,93,17,80"  href="#" />
					<area shape="poly" coords="440,104,467,107,487,117,500,132,521,129,544,132,561,141,571,151,593,151,616,158,630,176,628,193,608,209,589,215,573,214,567,233,546,250,513,260,482,259,457,248,435,256,400,253,378,242,367,222,347,222,325,214,315,198,322,179,343,170,348,155,367,144,393,141,400,123,418,110"  href="#" />
					<area shape="poly" coords="646,55,658,42,682,33,701,33,716,36,732,19,754,10,780,9,802,16,818,28,824,45,847,48,867,58,875,74,894,83,901,100,894,117,872,126,849,126,844,139,826,153,795,161,773,159,758,153,738,161,707,164,683,159,657,146,647,134,643,118,624,118,599,109,588,96,586,82,595,68,615,56,630,54"  href="#" />
					<area shape="poly" coords="243,257,268,253,292,258,307,267,315,276,341,275,358,284,370,294,374,309,366,326,349,336,329,341,318,340,310,357,292,373,268,383,232,385,201,374,176,381,148,380,128,371,115,358,110,347,91,347,68,339,58,324,62,309,72,301,86,295,94,279,111,268,133,266,144,247,164,234,187,229,212,232,231,243"  href="#" />
					<area shape="poly" coords="693,257,704,241,722,233,743,230,762,231,782,239,796,251,801,265,817,267,834,273,845,281,849,295,865,302,873,310,877,325,870,337,857,345,841,349,825,347,820,360,807,373,786,381,759,381,735,373,711,383,681,386,645,375,625,358,619,338,596,339,572,327,563,315,561,303,572,287,594,276,612,275,623,277,634,262,653,253,671,252"  href="#" />
				</map>
			</div>
			<input type="hidden" name="q11" value="0" />
		</div>
		<div id="12" class="questions">
			<div><div class="bulb"></div>Rank the following type of tasks you typically enjoy working on:</div>
			<div id="task_bar"></div>
			<ul id="favTask">
				<li id="q12_1"><span class="ui-icon ui-icon-grip-dotted-vertical"></span><font>Physical</font><br>skill, strength, coordination, accuracy</li>
				<li id="q12_2"><span class="ui-icon ui-icon-grip-dotted-vertical"></span><font>Strategic</font><br>thinking, organizing, understanding</li>
				<li id="q12_3"><span class="ui-icon ui-icon-grip-dotted-vertical"></span><font>Creative</font><br>originality, imagination, innovation</li>
				<li id="q12_4"><span class="ui-icon ui-icon-grip-dotted-vertical"></span><font>Competitive</font><br>leadership, influence, selling, status</li>
				<li id="q12_5"><span class="ui-icon ui-icon-grip-dotted-vertical"></span><font>Orderly</font><br>routine, regulation, process, precision</li>
				<li id="q12_6"><span class="ui-icon ui-icon-grip-dotted-vertical"></span><font>Community</font><br>helping, healing, developing others</li>
			</ul>
			<input type="hidden" name="q12" value="0" />			
		</div>
		<div id="13" class="questions">
			<div><div class="bulb"></div>When communicating ...</div>
			<div id="communications" class="clear">
				<img id="communicationOverlay" src="<?php echo base_url() ?>assets/images/imgOverlay.png" alt="cloud" usemap="#communicationCloud" />
				<map name="communicationCloud" id="communicationCloud">
					<area shape="poly" coords="32,72,40,56,61,45,83,43,92,22,110,10,139,5,164,10,181,20,190,33,214,30,238,34,256,45,261,52,288,53,310,63,321,80,317,98,301,111,281,116,263,117,254,140,226,156,199,162,171,161,148,150,126,158,95,156,72,146,61,132,58,123,39,125,20,119,8,104,7,93,17,80"  href="#" />
					<area shape="poly" coords="440,104,467,107,487,117,500,132,521,129,544,132,561,141,571,151,593,151,616,158,630,176,628,193,608,209,589,215,573,214,567,233,546,250,513,260,482,259,457,248,435,256,400,253,378,242,367,222,347,222,325,214,315,198,322,179,343,170,348,155,367,144,393,141,400,123,418,110"  href="#" />
					<area shape="poly" coords="646,55,658,42,682,33,701,33,716,36,732,19,754,10,780,9,802,16,818,28,824,45,847,48,867,58,875,74,894,83,901,100,894,117,872,126,849,126,844,139,826,153,795,161,773,159,758,153,738,161,707,164,683,159,657,146,647,134,643,118,624,118,599,109,588,96,586,82,595,68,615,56,630,54"  href="#" />
					<area shape="poly" coords="243,257,268,253,292,258,307,267,315,276,341,275,358,284,370,294,374,309,366,326,349,336,329,341,318,340,310,357,292,373,268,383,232,385,201,374,176,381,148,380,128,371,115,358,110,347,91,347,68,339,58,324,62,309,72,301,86,295,94,279,111,268,133,266,144,247,164,234,187,229,212,232,231,243"  href="#" />
					<area shape="poly" coords="693,257,704,241,722,233,743,230,762,231,782,239,796,251,801,265,817,267,834,273,845,281,849,295,865,302,873,310,877,325,870,337,857,345,841,349,825,347,820,360,807,373,786,381,759,381,735,373,711,383,681,386,645,375,625,358,619,338,596,339,572,327,563,315,561,303,572,287,594,276,612,275,623,277,634,262,653,253,671,252"  href="#" />
				</map>
			</div>
			<input type="hidden" name="q13" value="0" />
		</div>
		<div id="14" class="questions">
			<div><div class="bulb"></div>If you don't know something about your job, what are the<br>steps you would take to find the answers?</div>
			<div id="steps_bar"></div>
			<ul id="resource">
				<li id="q14_1"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Search the Internet</li>
				<li id="q14_2"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Search Company Internal Websites</li>
				<li id="q14_3"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Find a Relevant Book</li>
				<li id="q14_4"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Ask Direct Supervisor / Manager</li>
				<li id="q14_5"><span class="ui-icon ui-icon-grip-dotted-vertical"></span>Ask Co-Workers</li>
			</ul>
			<input type="hidden" name="q14" value="0" />	
		</div>
		<div id="15" class="questions">
			<div><div class="bulb"></div>Which of the following is most effective role of a supervisor:</div>
			<div id="supervisor" class="clear">
				<img id="supervisorOverlay" src="<?php echo base_url() ?>assets/images/imgOverlay.png" alt="cloud" usemap="#supervisorCloud" />
				<map name="supervisorCloud" id="supervisorCloud">
					<area shape="poly" coords="84,47,88,35,98,24,110,16,127,11,141,10,158,12,172,18,186,27,192,37,210,35,225,34,240,39,252,44,263,56,289,57,305,63,318,73,324,88,319,100,307,111,295,117,280,120,266,120,260,136,246,151,228,160,209,165,188,166,168,163,150,155,132,161,112,163,88,158,74,149,65,138,60,128,42,129,26,124,13,113,8,101,13,86,23,78,37,77,39,64,53,53,67,49" href="#" />
					<area shape="poly" coords="379,131,383,117,394,107,409,97,427,93,446,94,460,97,474,105,487,122,503,117,521,118,540,124,551,132,558,140,578,139,598,145,612,157,618,169,613,186,598,198,581,203,560,203,555,221,538,236,519,246,492,249,468,246,445,238,425,244,400,245,373,237,361,224,353,210,337,213,314,205,303,193,304,176,315,165,331,159,334,143,354,131" href="#" />
					<area shape="poly" coords="649,60,656,48,673,38,697,36,717,41,730,26,751,15,775,12,795,15,816,27,824,39,826,48,848,51,863,57,872,66,877,79,893,86,902,97,901,110,891,124,868,131,851,130,844,145,826,158,798,165,778,163,761,158,743,164,722,168,696,165,671,157,655,144,645,122,626,121,605,115,588,98,588,80,601,67,625,58" href="#" />
					<area shape="poly" coords="94,236,101,218,117,206,136,200,155,199,174,203,189,210,201,226,220,223,241,225,259,231,273,246,293,245,313,250,326,260,332,274,325,295,304,307,275,309,268,328,247,345,215,355,183,353,159,344,141,350,112,350,87,341,74,329,68,315,49,318,28,310,17,291,26,273,43,266,55,246,76,237" href="#" />
					<area shape="poly" coords="380,327,392,314,412,305,435,304,451,308,463,291,486,282,512,281,531,285,549,296,555,307,557,317,576,318,593,324,603,334,607,345,619,351,631,361,634,374,626,387,611,398,594,399,583,397,578,410,561,424,541,431,518,433,504,429,493,425,470,434,437,435,408,428,388,415,379,401,377,390,352,389,331,380,321,368,320,353,335,334,359,326" href="#" />
					<area shape="poly" coords="664,240,678,226,699,218,716,217,735,222,749,205,770,196,796,193,818,199,835,210,844,231,864,232,882,240,890,250,893,260,909,267,919,279,919,290,909,304,889,312,869,311,861,325,840,340,812,345,790,343,777,338,754,347,722,349,697,343,676,329,666,317,662,302,646,303,626,297,614,288,605,274,609,258,623,246,643,240" href="#" />
				</map> 
			</div>
			<input type="hidden" name="q15" value="0" />
		</div>
		<div id="16" class="questions">
			<div><div class="bulb"></div>When you ignore a strong gut feel<br>that's trying to tell you something, you tend to regret it later on.</div>
			<div id="intuition">
				<div id="true" class="true_false">True</div>
				<div id="false" class="true_false">False</div>
			</div>
			<input type="hidden" name="q16" value="0" />
		</div>
		<div id="17" class="questions">
			<div><div class="bulb"></div>When someone makes inappropriate or derogatory remarks, you typically ...</div>
			<div id="respect" class="clear">
				<img id="respectOverlay" src="<?php echo base_url() ?>assets/images/imgOverlay.png" alt="cloud" usemap="#respectCloud" />
				<map name="respectCloud" id="respectCloud">
					<area shape="poly" coords="32,72,40,56,61,45,83,43,92,22,110,10,139,5,164,10,181,20,190,33,214,30,238,34,256,45,261,52,288,53,310,63,321,80,317,98,301,111,281,116,263,117,254,140,226,156,199,162,171,161,148,150,126,158,95,156,72,146,61,132,58,123,39,125,20,119,8,104,7,93,17,80"  href="#" />
					<area shape="poly" coords="440,104,467,107,487,117,500,132,521,129,544,132,561,141,571,151,593,151,616,158,630,176,628,193,608,209,589,215,573,214,567,233,546,250,513,260,482,259,457,248,435,256,400,253,378,242,367,222,347,222,325,214,315,198,322,179,343,170,348,155,367,144,393,141,400,123,418,110"  href="#" />
					<area shape="poly" coords="646,55,658,42,682,33,701,33,716,36,732,19,754,10,780,9,802,16,818,28,824,45,847,48,867,58,875,74,894,83,901,100,894,117,872,126,849,126,844,139,826,153,795,161,773,159,758,153,738,161,707,164,683,159,657,146,647,134,643,118,624,118,599,109,588,96,586,82,595,68,615,56,630,54"  href="#" />
					<area shape="poly" coords="243,257,268,253,292,258,307,267,315,276,341,275,358,284,370,294,374,309,366,326,349,336,329,341,318,340,310,357,292,373,268,383,232,385,201,374,176,381,148,380,128,371,115,358,110,347,91,347,68,339,58,324,62,309,72,301,86,295,94,279,111,268,133,266,144,247,164,234,187,229,212,232,231,243"  href="#" />
					<area shape="poly" coords="693,257,704,241,722,233,743,230,762,231,782,239,796,251,801,265,817,267,834,273,845,281,849,295,865,302,873,310,877,325,870,337,857,345,841,349,825,347,820,360,807,373,786,381,759,381,735,373,711,383,681,386,645,375,625,358,619,338,596,339,572,327,563,315,561,303,572,287,594,276,612,275,623,277,634,262,653,253,671,252"  href="#" />
				</map>
			</div>
			<input type="hidden" name="q17" value="0" />
		</div>
		<div id="18" class="questions">
			<div><div class="bulb"></div>How would you effectively lead a team?</div>
			<div id="leadership" class="clear">
				<img id="leadershipOverlay" src="<?php echo base_url() ?>assets/images/imgOverlay.png" alt="cloud" usemap="#leadershipCloud" />
				<map name="leadershipCloud" id="leadershipCloud">
					<area shape="rect" coords="1,1,324,418" href="#" />
					<area shape="rect" coords="324,1,648,418" href="#" />
					<area shape="rect" coords="648,-1,972,418" href="#" />
				</map>
			</div>
			<input type="hidden" name="q18" value="0" />
		</div>
		<div id="19" class="questions">
			<div><div class="bulb"></div>Pick the top 10 traits of people you enjoy being around:</div>
			<div id="traits">
				<div>Affectionate</div>
				<div>Competent</div>
				<div>Patient</div>
				<div>Dependable</div>
				<div>Loyal</div>
				<div>Respectful</div>
				<div>Sincere</div>
				<div>Calm</div>
				<div>Intelligent</div>
				<div>Creative</div>
				<div>Supportive</div>
				<div>Ambitious</div>
				<div>Genuine</div>
				<div>Courageous</div>
				<div>Compassionate</div>
				<div>Collaborative</div>
				<div>Integrity</div>
				<div>Passionate</div>
				<div>Determined</div>
				<div>Straightforward</div>
				<div>Warm</div>
				<div>Energetic</div>
				<div>Assertive</div>
				<div>Humble</div>
				<div>Predictable</div>
				<div>Proud</div>
				<div>Clever</div>
				<div>Wise</div>
				<div>Sociable</div>
				<div>Tactful</div>
				<div>Inspiring</div>
				<div>Confident</div>
				<div>Trustworthy</div>
				<div>Competitive</div>
				<div>Humorous</div>
			</div>
			<input type="hidden" name="q19" value="0" />
		</div>
		<div id="20" class="questions">
			<div><div class="bulb"></div>I want to work ________</div>
			<div id="motivation" class="clear">
				<img id="motivationOverlay" src="<?php echo base_url() ?>assets/images/imgOverlay.png" alt="cloud" usemap="#motivationCloud" />
				<map name="motivationCloud" id="motivationCloud">
					<area shape="poly" coords="32,72,40,56,61,45,83,43,92,22,110,10,139,5,164,10,181,20,190,33,214,30,238,34,256,45,261,52,288,53,310,63,321,80,317,98,301,111,281,116,263,117,254,140,226,156,199,162,171,161,148,150,126,158,95,156,72,146,61,132,58,123,39,125,20,119,8,104,7,93,17,80"  href="#" />
					<area shape="poly" coords="440,104,467,107,487,117,500,132,521,129,544,132,561,141,571,151,593,151,616,158,630,176,628,193,608,209,589,215,573,214,567,233,546,250,513,260,482,259,457,248,435,256,400,253,378,242,367,222,347,222,325,214,315,198,322,179,343,170,348,155,367,144,393,141,400,123,418,110"  href="#" />
					<area shape="poly" coords="646,55,658,42,682,33,701,33,716,36,732,19,754,10,780,9,802,16,818,28,824,45,847,48,867,58,875,74,894,83,901,100,894,117,872,126,849,126,844,139,826,153,795,161,773,159,758,153,738,161,707,164,683,159,657,146,647,134,643,118,624,118,599,109,588,96,586,82,595,68,615,56,630,54"  href="#" />
					<area shape="poly" coords="243,257,268,253,292,258,307,267,315,276,341,275,358,284,370,294,374,309,366,326,349,336,329,341,318,340,310,357,292,373,268,383,232,385,201,374,176,381,148,380,128,371,115,358,110,347,91,347,68,339,58,324,62,309,72,301,86,295,94,279,111,268,133,266,144,247,164,234,187,229,212,232,231,243"  href="#" />
					<area shape="poly" coords="693,257,704,241,722,233,743,230,762,231,782,239,796,251,801,265,817,267,834,273,845,281,849,295,865,302,873,310,877,325,870,337,857,345,841,349,825,347,820,360,807,373,786,381,759,381,735,373,711,383,681,386,645,375,625,358,619,338,596,339,572,327,563,315,561,303,572,287,594,276,612,275,623,277,634,262,653,253,671,252"  href="#" />
				</map>
			</div>
			<input type="hidden" name="q20" value="0" />
		</div>
		<div id="21" class="questions">
			<div>Congrats! You finished</div>
		</div>
		<div id="progressBar">
			<ul>
				<li class="progress ip"></li>
				<li class="progress"></li>
				<li class="progress"></li>
				<li class="progress"></li>
				<li class="progress"></li>
				<li class="progress"></li>
				<li class="progress"></li>
				<li class="progress"></li>
				<li class="progress"></li>
				<li class="progress"></li>
				<li class="progress"></li>
				<li class="progress"></li>
				<li class="progress"></li>
				<li class="progress"></li>
				<li class="progress"></li>
				<li class="progress"></li>
				<li class="progress"></li>
				<li class="progress"></li>
				<li class="progress"></li>
				<li class="progress"></li>
			</ul>
		</div>
	</div>
	<div class="preload">
		<img src="<?php echo base_url() ?>assets/images/survey/slider_4markers.jpg">
		<img src="<?php echo base_url() ?>assets/images/survey/harvey_ball_10.png">
		<img src="<?php echo base_url() ?>assets/images/survey/recognition_bar.png">
		<img src="<?php echo base_url() ?>assets/images/survey/politics.jpg">
		<img src="<?php echo base_url() ?>assets/images/survey/task_bar.png">		
		<img src="<?php echo base_url() ?>assets/images/survey/communication.jpg">
		<img src="<?php echo base_url() ?>assets/images/survey/resourceSteps.png">
		<img src="<?php echo base_url() ?>assets/images/survey/supervisor.jpg">
		<img src="<?php echo base_url() ?>assets/images/survey/true_false.png">
		<img src="<?php echo base_url() ?>assets/images/survey/respect.jpg">
		<img src="<?php echo base_url() ?>assets/images/survey/leadership.jpg">
		<img src="<?php echo base_url() ?>assets/images/survey/motivation.jpg">
		<img src="<?php echo base_url() ?>assets/images/survey/progressIcon.png">
		<img src="<?php echo base_url() ?>assets/images/preview.png">
		<img src="<?php echo base_url() ?>assets/images/netapp.png">
	</div>
</div>
