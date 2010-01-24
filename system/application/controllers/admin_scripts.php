<?php

class Admin_Scripts extends Application {

	function Admin_Scripts()
	{
		parent::Application();	
		$this->auth->restrict('user');
	}
	
	function index()
	{
		// Set a few globals
		$data = array(
						'page_title' => 'Welcome to Inn Strategy'
					);

		$this->load->vars($data);

		$this->load->helper('url');
		$this->load->helper('html');
		
		$this->load->view('header_user');
		$this->load->view('admin_scripts');
		$this->load->view('footer_std');

	}
	
	function edit()
	{
		// Set a few globals
		$data = array(
						'page_title' => 'Welcome to Inn Strategy'
					);

		//if(!isset($_POST))
			$data['rec_count'] = $this->get_BBData_Count();

		$this->load->vars($data);

		$singleID = '';
		
		if(isset($_POST['btnClearLog']))
			$this->ClearLog();
		else
		{
			if(isset($_POST['ProcType']))
			{
				switch($_POST['ProcType'])
				{
					case 'S':
						$this->form_validation->set_rules('txtID', 'Single Record ID', 'trim|required|is_natural_no_zero');
						break;
					case 'G':
						$this->form_validation->set_rules('txtFirst', 'First Record ID', 'trim|required|is_natural_no_zero');
						$this->form_validation->set_rules('txtLast', 'Last Record ID', 'trim|required|is_natural_no_zero');
						$this->form_validation->set_rules('txtLast', 'Last Record ID', 'callback_range_check');
						break;
				}
			
				if ($this->form_validation->run() != false)
				{
					switch($_POST['ProcType'])
					{
						case 'S':
							$singleID = $_POST['txtID'];
							break;
						case 'G':
							$singleID = $_POST['txtFirst'] . " AND " . $_POST['txtLast'];
							break;
					}
	
					if(!empty($singleID) || isset($_POST['btnClearLog']))
					{
						$this->benchmark->mark('code_start');

						if(isset($_POST['btnQuantcast']))
							$this->GetQuantCast($singleID);
						else if(isset($_POST['btnCompete']))
							$this->GetCompete($singleID);
						else if(isset($_POST['btnQuantified']))
							$this->GetQuantified($singleID);
						else if(isset($_POST['btnMSN']))
							$this->GetIndexed("MSN", $singleID);
						else if(isset($_POST['btnGoogle']))
							$this->GetIndexed("Google", $singleID);
						else if(isset($_POST['btnYahoo']))
							$this->GetIndexed("Yahoo", $singleID);
						//else if(isset($_POST['btnPageRank']))
						//	$this->GetMaxPageRank($singleID);
						//else if(isset($_POST['btnPageRankLink']))
						//	$this->GetLinkPageRank($singleID);
						else if(isset($_POST['btnScore']))
							$this->GetScore($singleID);
						else if(isset($_POST['btnNoFollow']))
							$this->GetNoFollow($singleID);
						else if(isset($_POST['btnClearLog']))

						$this->benchmark->mark('code_end');
					}
				}
			}
		}
		
		$this->load->helper('url');
		$this->load->helper('html');
		
		$this->load->view('header_user');
		$this->load->view('admin_scripts');
		$this->load->view('footer_std');

		if(!empty($singleID))
		{
			$proc_count = $this->get_BBData_Count($singleID);
			print "Elapsed Time for " . $proc_count . " Record" . ($proc_count == 1 ? '' : 's') . ": " . $this->formatTime($this->benchmark->elapsed_time('code_start', 'code_end'));
		}
	}
	
	function range_check()
	{
		if ($_POST['txtLast'] <= $_POST['txtFirst'])
		{
			$this->form_validation->set_message('range_check', 'Last Record ID must be <strong>greater</strong> than First Record ID');
			return false;
		}
		else
		{
			return true;
		}
	}
	
    function GetQuantCast($singleID="")
	{
		$dsDetails = $this->get_BBData_select($singleID);
        $strArgs = "-q";

        $this->WriteLog("Update QuantCast started.");

		$i = 1;
		$iCount = sizeof($dsDetails);
		
        foreach($dsDetails as $row)
		{
			$strResult = '';

            $strWebsite = $row['WebsiteText'];
            $strWebsiteURL = $row['Website'];
            $strBBDataID = $row['BBDataId'];
            $strQuantified = $row['Quantified'];
			$strDBQuantcastCurrent = $row['DBQuantcastCurrent'];
			$strDBQuantcastPrevious = $row['DBQuantcastPrevious'];
			$strDBQuantcastCurrentDataDate = $row['QuantcastCurrentDataDate'];

            try
			{
                $strResult = $this->QuantCast($strWebsite, $strWebsiteURL, $strQuantified, $strDBQuantcastCurrent, $strDBQuantcastPrevious, $strDBQuantcastCurrentDataDate, $strBBDataID);

                $this->WriteLog("[" . ($i) . " of " . ($iCount) . "] " . "ID: " . $strBBDataID . " Current Site : " . $strWebsite . " | Results = " . $strResult);
			}
            catch(Exception $ex)
			{
                $this->WriteLog("GetQuantCast ERROR:: ID = " . $strBBDataID . " Current Site = " . $strWebsite . "\n" . $ex);
                return false;
			}
			$i++;
        }
        $this->WriteLog("Update QuantCast ended.\n");
        return true;
    }

	function QuantCast($strWebsite, $strWebsiteURL, $blnQuantified, $strDBQuantcastCurrent, $strDBQuantcastPrevious, $strDBQuantcastCurrentDataDate, $BBDataID)
	{

        $strReturn = '';
        $strURL = "http://www.quantcast.com/" . trim($strWebsite) . "/traffic";

		$strHTMLText = $this->Get_Live_Data($strURL);
		if(empty($strHTMLText))
			return "";
		
        try
		{
            $strQuantcastCurrentDataDate = '';
            $QuantcastCurrentDataDate = '';
            $s = '';
            $number = '';
            $million = false;
            $thousand = false;
            $bdecimal = false;
            $cntDec = '';
            $intPos0 = '';
			$intPos1 = '';
			$intPos2 = '';
			$intPos3 = '';
			$intPos4 = '';
			$intPos5 = '';
            $monthlyUniques = 0;

            $intPos1 = strpos($strHTMLText, "People per Month"); 
            if($intPos1 > 0)
                $intPos2 = strpos($strHTMLText, "digit", $intPos1) + 7;

            if($intPos2 > 0)
                $intPos3 = strpos($strHTMLText, "digit", $intPos2) + 7;

            if($intPos3 > 0)
                $intPos4 = strpos($strHTMLText, "</td>", $intPos3);


            $s = substr($strHTMLText, $intPos3, $intPos4 - $intPos3);


            if(!is_numeric($s))
 			{
				$intPos1 = strpos($strHTMLText, "People per Month", 0);
                if($intPos1 > 0)
					$intPos2 = strpos($strHTMLText, "digit", $intPos1) + 7;
         
                if($intPos2 > 0)
					$intPos3 = strpos($strHTMLText, "</td>", $intPos2);

				$s = substr($strHTMLText, $intPos2, $intPos3 - $intPos2);
            }

            if(!is_numeric($s))
 			{
				$monthlyUniques = 1;
				$intPos1 = strpos($strHTMLText, "This site reaches approximately ", 0);
                if($intPos1 > 0)
				{
                    $intPos2 = strpos($strHTMLText, " U.S.", $intPos1);
                    $s = substr($strHTMLText, $intPos1 + 32, ($intPos2 - $intPos1) - 32);
                 }
            }
//if($BBDataID == 34) {$this->WriteLog(substr($strHTMLText, $intPos1 + 32, ($intPos2 - $intPos1) - 32)); $this->WriteLog($intPos1."~".$intPos2); die();}

            if(!is_numeric($s))
 			{
				$monthlyUniques = 1;
                $intPos1 = strpos($strHTMLText, "This site reaches over ", 0);
                if($intPos1 > 0)
 				{
                    $intPos2 = strpos($strHTMLText, " monthly", $intPos1);
                    $s = substr($strHTMLText, $intPos1 + 22, ($intPos2 - $intPos1) - 22);
                }
            }
//if($BBDataID == 34) {$this->WriteLog($s); }
            if(trim($s) !== "")
			{
                if(strpos(strtolower($s), "million") > 0)
 				{
                	$million = true;
                    if(strpos($s, ".") > 0)
                        $bdecimal = true;
                }

                if((strpos(strtolower($s), "thousand") > 0) || (strpos(strtolower($s), "k ") > 0))
                    $thousand = true;

                if(strpos($s,"<") !== false)
                    $number = 1;
                else
				{
                    for($j = 0; $j<strlen($s); $j++)
					{
                        if(is_numeric(substr($s, $j, 1)) || (substr($s, $j, 1) === "."))
                            $number .= substr($s, $j, 1);
						if((strlen($number) > 0) && !is_numeric(substr($s, $j, 1)) && (substr($s, $j ,1) !== "."))
							break;
                    }
              	}
//if($BBDataID == 34) die($strURL . "|".$number);
                if(strpos($number, ".") !== false)
                    $cntDec = (strlen($number) - strpos($number, ".") - 1);

                if($million)
 				{
					$number = str_replace(".", "", $number);
                    $number .= "000000";
                    $number = substr($number, 0, strlen($number) - $cntDec);
                }

                if($thousand)
                    $number .= "000";

                if(empty($number))
                    $monthlyUniques = 1;
                else
                    $monthlyUniques = $number;
            }

            if(strpos($strWebsite, "/") < 1)
			{
                if($blnQuantified)
 				{
                    $QuantcastCurrentDataDate = date('m/d/Y');
                    $QuantcastCurrentDataDate = $this->add_date($QuantcastCurrentDataDate, 1);	//add a day
				}
                else
				{
                    $QuantcastCurrentDataDate = $this->add_date(date('m/d/Y'), 0, 1);	//add a month
                    $QuantcastCurrentDataDate = $this->last_day_of_month($QuantcastCurrentDataDate);
				}
			}
            else
			{
                $QuantcastCurrentDataDate = $this->add_date(date('m/d/Y'), 0, 1);	//add a month
                $QuantcastCurrentDataDate = $this->last_day_of_month($QuantcastCurrentDataDate);
                $monthlyUniques = 0;
            }

            $this->BBData_Quantcast_Update($monthlyUniques, (empty($QuantcastCurrentDataDate) ? date('m/d/Y') : $QuantcastCurrentDataDate), 
																$strDBQuantcastCurrent, $strDBQuantcastPrevious, $strDBQuantcastCurrentDataDate, $BBDataID);

            $strReturn = "QuantcastCurrentDataDate = " . (empty($QuantcastCurrentDataDate) ? date('m/d/Y') : $QuantcastCurrentDataDate) . " QuantcastCurrent = " . $monthlyUniques;
		}
        catch(Exception $ex)
		{
			$this->WriteLog("Quantcast PARSE ERROR:: BBDataID = " . $BBDataID);
			$strReturn = '';
		}

        return $strReturn;
    }

	function BBData_Quantcast_Update($QuantcastCurrent, $QuantcastCurrentDataDate, $DBQuantcastCurrent, $DBQuantcastPrevious, $DBQuantcastCurrentDataDate, $BBDataID)
	{
		$QuantcastChange = '';
/*
		$DBQuantcastCurrent = '';
		$DBQuantcastPrevious = '';
		$DBQuantcastCurrentDataDate = '';

		$sql = "SELECT COALESCE(QuantcastCurrent,0) AS DBQuantcastCurrent, COALESCE(QuantcastPrevious,0) AS DBQuantcastPrevious, QuantcastCurrentDataDate AS DBQuantcastCurrentDataDate 
				FROM BBData
				WHERE BBDataId = " . $BBDataID;

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0)
		{
		   $row = $query->row();
*/
			if($QuantcastCurrent == 1)
				$QuantcastChange = '0';

			if($DBQuantcastCurrent == 1)
				$QuantcastChange = '0';

			if($DBQuantcastCurrent == $QuantcastCurrent)
			{
			 	if($DBQuantcastCurrent > 1)
					$QuantcastChange = '0.0';
				else
					$QuantcastChange = '0';
			}
			else
			{
				if(($QuantcastCurrent > 1) && ($DBQuantcastCurrent > 1))
					$QuantcastChange = ((intval($QuantcastCurrent) - intval($DBQuantcastCurrent)) / intval($DBQuantcastCurrent)) * 100;
			}
//		}

		if(($DBQuantcastCurrent <> $QuantcastCurrent) || ($DBQuantcastCurrentDataDate <> $QuantcastCurrentDataDate))
		{
			try
			{
			$sql = "UPDATE BBData
					SET QuantcastCurrent = " . $QuantcastCurrent . ",
					QuantcastCurrentDataDate = '" . $QuantcastCurrentDataDate . "',
					QuantcastPrevious = " . $DBQuantcastCurrent . ",
					QuantcastChange = " . $QuantcastChange . "
					WHERE BBDataId = " . $BBDataID;
					
			if($this->config->item('app_debug') === true)
				$this->WriteLog($sql);

			$this->db->query($sql);
			}
			catch(Exception $ex)
			{
				$this->WriteLog("SQL ERROR::". $ex . " :: " . $sql);
			}
		}
	}

	function GetQuantified($singleID="")
	{
       	$bReturn = true;
		$strArgs = "-q";
        $intResult = "";
	    $this->WriteLog("Update Quantified started.");
		$dsDetails = $this->get_BBData_select($singleID);

		$i = 1;
		$iCount = sizeof($dsDetails);
        
	    foreach($dsDetails as $row)
		{
            $strWebsite = $row["WebsiteText"];
            $strWebsiteURL = $row["Website"];
            $strBBDataID = $row["BBDataId"];
			$strDBQuantified = $row["Quantified"];
            try
			{
                $intResult = $this->Quantified($strWebsite, $strWebsiteURL, $strDBQuantified, $strBBDataID);

                $this->WriteLog("[" . $i . " of " . $iCount . "] " . "ID = " . $strBBDataID . " Current Site = " . $strWebsite . " | Results = " . $intResult);
			}
            catch(Exception $ex)
			{
                $this->WriteLog("GetQuantified ERROR:: ID = " . $strBBDataID . " Current Site = " . $strWebsite . "\n" . $ex);
                $bReturn = false;

            }
        }

        $this->WriteLog("Update Quantified ended.\n");
        return $bReturn;
	}
	
	function Quantified($strWebsite, $strWebsiteURL, $strDBQuantified, $strBBDataID)
	{
        $strArgs = "-u";
        $strHTMLText = "";
        $intQuantified = 0;
        $strURL = "http://www.quantcast.com/" . $strWebsite;

		$strHTMLText = $this->Get_Live_Data($strURL);
		if(empty($strHTMLText))
			return "";

        try
		{
            if(strpos($strHTMLText, "qfied_seal.png") !== false)
                $intQuantified = 1;
            else
                $intQuantified = 0;

            $this->BBData_Quantified_Update($intQuantified, $strDBQuantified, $strBBDataID);
		}
        catch(Exception $ex)
		{
            $this->WriteLog("GetQuantified ERROR:: ID = " . $strBBDataID . " Current Site = " . $strWebsite . "\n" . $ex);

        }
        return $intQuantified;		
	}
	
	function BBData_Quantified_Update($Quantified, $DBQuantified, $BBDataID)
	{
		if($DBQuantified != $Quantified)
		{
			try
			{
				$sql = "UPDATE BBData 
						SET Quantified = " . (empty($Quantified) ? 'NULL' : $Quantified) . "
						WHERE BBDataId = " . $BBDataID;
						
				if($this->config->item('app_debug') === true)
					$this->WriteLog($sql);

				$this->db->query($sql);
			}
			catch(Exception $ex)
			{
				$this->WriteLog("SQL ERROR::". $ex . " :: " . $sql);
			}
		}
	}
	
	function GetCompete($singleID="")
	{
		$bReturn = true;
	    $strArgs = "-c";
	    $strResult = "";
	    $this->WriteLog("Update Compete started.");
		$dsDetails = $this->get_BBData_select($singleID);

		$i = 1;
		$iCount = sizeof($dsDetails);
        
	    foreach($dsDetails as $row)
		{
            $strWebsite = $row["WebsiteText"];
            $strWebsiteURL = $row["Website"];
            $strBBDataID = $row["BBDataId"];
			$strDBCompeteCurrent = $row['DBCompeteCurrent'];
			$strDBCompeteCurrentDataDate = $row['CompeteCurrentDataDate'];
            try
			{
                $strResult = $this->Compete($strWebsite, $strWebsiteURL, $strDBCompeteCurrent, $strDBCompeteCurrentDataDate, $strBBDataID);

                $this->WriteLog("[" . $i . " of " . $iCount . "] " . "ID = " . $strBBDataID . " Current Site = " . $strWebsite . " | Results = " . $strResult);
			}
            catch(Exception $ex)
			{
                WriteLog("GetCompete ERROR:: ID = " . $strBBDataID . " Current Site = " . $strWebsite . "\n" . $ex);
                $bReturn = false;

            }
        }
        $this->WriteLog("Update Compete ended.\n");
        return $bReturn;
	}

	function Compete($strWebsite, $strWebsiteURL, $DBCompeteCurrent, $strDBCompeteCurrentDataDate, $strBBDataID)
	{
	        $strReturn = "";
	        $strURL = "http://siteanalytics.compete.com/" . $strWebsite;
	        $strCompeteCurrentDataDate = "";
	        $strHTMLText = "";
	        $monthlyUniques = "";
			$CompeteCurrentDataDate = "";
//print($strURL);
			$strHTMLText = $this->Get_Live_Data($strURL);
			if(empty($strHTMLText))
				return "";

			try
			{
				$intPos0 = "";
				$intPos1 = "";
				$intPos2 = "";
				$intPos3 = "";
				$intPos4 = "";
				$s = "";
				$number = "";
				$million = false;
				$thousand = false;

	            $intPos0 = strpos($strHTMLText, "id=\"uv\"", 0);
	            if($intPos0 > 0)
	 			{

	                $intPos1 = strpos($strHTMLText, "class=\"date\"", 0);
	                $intPos2 = strpos($strHTMLText, "</span>", $intPos1);
	                $strCompeteCurrentDataDate = substr($strHTMLText, $intPos1 + 13, ($intPos2 - $intPos1) - 13);
	            }

				$strCompeteCurrentDataDate = trim($strCompeteCurrentDataDate);
	            if(!empty($strCompeteCurrentDataDate))
	 			{
	                $CompeteCurrentDataDate = $strCompeteCurrentDataDate;
	                $CompeteCurrentDataDate = $this->add_date($QuantcastCurrentDataDate, 0, 1);	//Add a month
	                $CompeteCurrentDataDate = last_day_of_month($CompeteCurrentDataDate);


	                $intPos3 = strpos($strHTMLText, "class=\"number value\"", $intPos0);
	                $intPos4 = strpos($strHTMLText, "</div>", $intPos3);
	                $s = substr($strHTMLText, $intPos3 + 21, ($intPos4 - $intPos3) - 21);

	                if(strpos(strtolower($s), "million") > 0)
	                    $million = true;

	                if(strpos(strtolower($s), "thousand") > 0)
	                    $thousand = true;

	                if(strpos($s, "<") > -1)
	                    $number = 1;
	                else
					{
	                	for($j=0; $j<strlen($s); $j)
						{
	                        if(is_numeric(substr($s, $j, 1)))
	                            $number .= substr($s, $j, 1);
	                    }
	                }

	                if($million)
	                    $number .= "000000";

	                if($thousand)
	                    $number .= "000";
				}

	            if(empty($number))
	                $monthlyUniques = 1;
	            else
	                $monthlyUniques = $number;

	            $this->BBData_Compete_Update($monthlyUniques, $DBCompeteCurrent, ($CompeteCurrentDataDate === "" ? date('m/d/Y') : $CompeteCurrentDataDate), $strDBCompeteCurrentDataDate, $strBBDataID);

	            $strReturn = "CompeteCurrentDataDate = " . ($CompeteCurrentDataDate === "" ? date('m/d/Y') : $CompeteCurrentDataDate) . " CompeteCurrent = " . $monthlyUniques;
	        }
			catch(Exception $ex)
			{
	            $CompeteCurrentDataDate = $this->add_date(date('m/d/Y'), 0, -1);	//Get previous month
	            $CompeteCurrentDataDate = last_day_of_month($CompeteCurrentDataDate);
	            $monthlyUniques = 0;

	            BBDataCompeteUpdate($monthlyUniques, ($CompeteCurrentDataDate === "" ? date('m/d/Y') : $CompeteCurrentDataDate), $strBBDataID);

	            $strReturn = "CompeteCurrentDataDate = " . $CompeteCurrentDataDate . " CompeteCurrent = " . $monthlyUniques . "\n" . $ex;
	        }
	        return $strReturn;
	}
	
	function BBData_Compete_Update($CompeteCurrent, $DBCompeteCurrent, $CompeteCurrentDataDate, $DBCompeteCurrentDataDate, $BBDataID)
	{
		$CompeteChange = '';

		if($CompeteCurrent == 1)
			$CompeteChange = '0';

		if($DBCompeteCurrent == 1)
			$CompeteChange = '0';

		if($DBCompeteCurrent == $CompeteCurrent)
		{
		 	if($DBCompeteCurrent > 1)
				$CompeteChange = '0.0';
			else
				$CompeteChange = '0';
		}
		else
		{
			if(($CompeteCurrent > 1) && ($DBCompeteCurrent > 1))
				$CompeteChange = (($CompeteCurrent - $DBCompeteCurrent) / $DBCompeteCurrent) * 100;
		}
		
		if(($DBCompeteCurrent != $CompeteCurrent) || ($DBCompeteCurrentDataDate != $CompeteCurrentDataDate))
		{
			try
			{
				$sql = "UPDATE BBData
					   SET CompeteCurrent = " . $CompeteCurrent . ",
						CompeteCurrentDataDate = " . $CompeteCurrentDataDate . ",
						CompetePrevious = " . $DBCompeteCurrent . ",
						CompeteChange = " . $CompeteChange . "
						WHERE BBDataId = " . $BBDataID;
						
				if($this->config->item('app_debug') === true)
					$this->WriteLog($sql);

				$this->db->query($sql);
			}
			catch(Exception $ex)
			{
				$this->WriteLog("SQL ERROR::". $ex . " :: " . $sql);
			}
		}
	}

	function GetIndexed($SearchEngine="Google", $singleID="")
	{
            $bReturn = true;

		    $this->WriteLog("Update Indexed started.");
			$dsDetails = $this->get_BBData_select($singleID);

			$i = 1;
			$iCount = sizeof($dsDetails);

		    foreach($dsDetails as $row)
			{
	            $strWebsite = $row["WebsiteText"];
                $strWebsiteIndexURL = $row["IndexPageURL"];
                $strBBDataID = $row["BBDataId"];
				$DBIndexByGoogle = (is_null($row["IndexByGoogle"]) || empty($row["IndexByGoogle"])) ? 'NULL' : $row["IndexByGoogle"];
				$DBIndexByYahoo = (is_null($row["IndexByYahoo"]) || empty($row["IndexByYahoo"])) ? 'NULL' : $row["IndexByYahoo"];
				$DBIndexByMSN = (is_null($row["IndexByMSN"]) || empty($row["IndexByMSN"])) ? 'NULL' : $row["IndexByMSN"];

	            try
				{
                $strIndex = $this->Index_By($SearchEngine, $strWebsiteIndexURL, $strWebsite, $DBIndexByGoogle, $DBIndexByYahoo, $DBIndexByMSN, $strBBDataID);

                $this->WriteLog("[" . $i . " of " . $iCount . "] " . "ID = " . $strBBDataID . " Current Site = " . $strWebsiteIndexURL . " Engine = " . $SearchEngine . " | Indexed = " . $strIndex);
				}
	            catch(Exception $ex)
				{
	                $this->WriteLog("GetIndexed ERROR:: ID = " . $strBBDataID . " Current Site = " . $strWebsite . "\n" . $ex);
	                $bReturn = false;

	            }
            }

	        $this->WriteLog("Update Indexed ended.\n");
            return $bReturn;
	}
	
	function Index_By($SearchEngine, $strWebsiteURL, $strWebsite, $DBIndexByGoogle, $DBIndexByYahoo, $DBIndexByMSN, $strBBDataID)
	{
		$strIndex = "";
		$sEngine = strtoupper($SearchEngine);
		$strArgs = "-" . strtolower(substr($sEngine,0,1));
		$strHTMLText = "";
		$engineURL = array("GOOGLE" =>"http://www.google.com/search?q=",
		 					"YAHOO" => "http://search.yahoo.com/search?p=",
							"MSN" => "http://www.bing.com/search?q=");
		
		$strWebsiteURL = trim($strWebsiteURL);
		try
		{
			if(!empty($strWebsiteURL))
			{
				$strWebsiteURL = $this->fix_URL($strWebsiteURL);
			
		        $strURL = $engineURL[$sEngine] . $strWebsiteURL;
		
				$strHTMLText = $this->Get_Live_Data($strURL);
				if(empty($strHTMLText))
					return "";

				$intPos1 = -1;
				$intPos0 = -1;
				if($sEngine === "GOOGLE")
				{
					$intPos1 = strpos($strHTMLText, "did not match any documents", 0);
					if($intPos1 === false)
					{
						$intPos1 = strpos($strHTMLText, "No results found for", 0);
						if($intPos1 === false)
						{
							$intPos1 = strpos($strHTMLText, "Did you mean", 0);
							if($intPos1 !== false)
							{
								$strURL = $engineURL[$sEngine]  . "%22" . $strWebsiteURL . "%22";	//try again with double-quotes around the siteURL

								$strHTMLText = $this->Get_Live_Data($strURL);
								if(empty($strHTMLText))
									return "";

								$intPos1 = strpos($strHTMLText, "did not match any documents", 0);
								if($intPos1 === false)
									$intPos1 = strpos($strHTMLText, "No results found for", 0);
							}
						}
					}
				}
				else if ($sEngine === "YAHOO")
					$intPos1 = strpos($strHTMLText, "We did not find results for", 0);
				else if ($sEngine === "MSN")
					$intPos1 = strpos($strHTMLText, "We did not find any results for", 0);

		        if($intPos1 > 0)
		            $strIndex = "No";
		        else
		            $strIndex = "Yes";
			}
		    else
		        $strIndex = "NULL";

	        $this->BBData_IndexBy_Update($strIndex, (($sEngine === "GOOGLE") ? $DBIndexByGoogle : (($sEngine === "YAHOO") ? $DBIndexByYahoo : $DBIndexByMSN)), $sEngine, $strBBDataID);
		}
		catch(Exception $ex)
		{
		 $this->WriteLog("Index By ERROR:: ID = " . $strBBDataID . " Current Site = " . $strWebsite . " Search Engine = " . $sEngine . "\n" . $ex);
		}

		return $strIndex;
	}
	
	function BBData_IndexBy_Update($NewValue, $DBPreviousValue, $sEngine, $BBDataID)
	{
		if($DBPreviousValue != $NewValue)
		{
			try
			{
				$sql = "UPDATE BBData 
						SET " . (($sEngine === "GOOGLE") ? 'IndexByGoogle' : (($sEngine === "YAHOO") ? 'IndexByYahoo' : 'IndexByMSN')) . " = '" . (empty($NewValue) ? 'NULL' : $NewValue) . "'
						WHERE BBDataId = " . $BBDataID;
						
				if($this->config->item('app_debug') === true)
					$this->WriteLog($sql);

				$this->db->query($sql);
			}
			catch(Exception $ex)
			{
				$this->WriteLog("SQL ERROR::". $ex . " :: " . $sql);
			}
		}
	}
	
	function GetMaxPageRank($singleID="")
	{
		$bReturn = true;
        $strArgs = "-m";
        $strResult = "";
        $this->WriteLog("Update PageRank started.");

		$dsDetails = $this->get_BBData_select($singleID);

		$i = 1;
		$iCount = sizeof($dsDetails);

	    foreach($dsDetails as $row)
		{
            $strWebsite = $row["WebsiteText"];
        	$strWebsiteURL = $row["Website"];
        	$strWebsiteIndexURL = $row["IndexPageURL"];
            $strBBDataID = $row["BBDataId"];

            try
			{
                $strResult = $this->Page_Rank_Checker_Max($strWebsite, $strWebsiteURL, $strWebsiteIndexURL, $strBBDataID);

	            $this->WriteLog("[" . $i . " of " . $iCount . "] " . "ID = " . $strBBDataID . " Current Site = " . $strWebsite . " | Indexed = " . $strResult);
			}
            catch(Exception $ex)
			{
                $this->WriteLog("GetMaxPageRank ERROR:: ID = " . $strBBDataID . " Current Site = " . $strWebsite . "\n" . $ex);
                $bReturn = false;

            }
        }

        $this->WriteLog("Update PageRank ended.\n");
        return $bReturn;
	}
	
	function Page_Rank_Checker_Max($strWebsite, $strWebsiteURL, $strWebsiteIndexURL, $strBBDataID)
	{
		$strReturn = "";
		$strHTMLText = "";
        //request As WebRequest = WebRequest.Create("http://checkpageranking.com/index.php")
        $payload = "name=" . $strWebsiteURL;

        $strURL = "http://checkpageranking.com/index.php?" . $payload;

		$strHTMLText = $this->Get_Live_Data($strURL);
		if(empty($strHTMLText))
			return "";

        try
		{
			/* *** IS ANY OF THIS REALLY NECCESSARY?
			/* *************************************
             Dim SomeBytes() As Byte
            Dim reserved() As Char = {ChrW(63), ChrW(61), ChrW(38)}	// ?, = , &

            if(!empty($payload))
			{
                $i = 0;
                $j = "";
                while($i < strlen($payload)
				{
                    $j = index_of_any(substr($payload, $i, 1), $reserved);
                    If j = -1 Then
                        UrlEncoded.Append(HttpUtility.UrlEncode(payload.Substring(i, payload.Length - i)))
                        Exit While
                    End If
                    UrlEncoded.Append(HttpUtility.UrlEncode(payload.Substring(i, j - i)))
                    UrlEncoded.Append(payload.Substring(j, 1))
                    i = j + 1
                }
                SomeBytes = System.Text.Encoding.UTF8.GetBytes(UrlEncoded.ToString())
                request.ContentLength = SomeBytes.Length
                requestStream = request.GetRequestStream()

                requestStream.Write(SomeBytes, 0, SomeBytes.Length)
                requestStream.Close()
            }
            response = request.GetResponse()
			*/
			
            $intPos0 = "";
			$intPos1 = "";
			$k = "";
			$number = "";

            $strret = "";

            $intPos0 = strpos($strHTMLText, "prnum", 0);
            if($intPos0 > 1)
			{
                $intPos1 = strpos($strHTMLText, "</b>", $intPos0);

                $strret = substr($strHTMLText, $intPos0, $intPos1 - $intPos0);
                $intPos0 = 0;
                $intPos0 = strpos($strret, "<b>", 0) + 3;
                if($intPos0 > 1)
				{
                    $strret = substr($strret, $intPos0);
                    for($k = 0; $k<strlen($strret); $k++)
					{
                        if(is_numeric(substr($strret, $k, 1)))
                            $number .= substr($strret, $k, 1);
                    }
                }
            else
                $number = 0;
            }

            $this->BBData_PageRank_Update($number, $strBBDataID);
            $strReturn = "PageRank URL = " . $strWebsiteURL . " Page Rank = " . $number;
		}
		catch(Exception $ex)
		{
		 $this->WriteLog("PageRank Checker Max ERROR:: ID = " . $strBBDataID . " Current Site = " . $strWebsite . "\n" . $ex);
		}

        return $strReturn;
	}
	
	function BBData_PageRank_Update($PageRank, $strBBDataID)
	{
		try
		{
			$sql = "UPDATE BBData
					SET MaxPR = " . $PageRank . "
					WHERE BBDataId = " . $BBDataId;
				
			if($this->config->item('app_debug') === true)
				$this->WriteLog($sql);

			$this->db->query($sql);
		}
		catch(Exception $ex)
		{
			$this->WriteLog("SQL ERROR::". $ex . " :: " . $sql);
		}
	}
	
	function GetLinkPageRank($singleID="")
	{ /*
		$strReturn = "";
        $request As WebRequest = WebRequest.Create("http://checkpageranking.com/index.php")
        $payload = "name=" . $strWebsiteIndexURL;


        Try

            request.Method = WebRequestMethods.Http.Post
            request.ContentType = "application/x-www-form-urlencoded"
            Dim SomeBytes() As Byte
            Dim UrlEncoded As New Text.StringBuilder
            Dim reserved() As Char = {ChrW(63), ChrW(61), ChrW(38)}

            If payload <> Nothing Then

                Dim i As Integer = 0
                Dim j As Integer
                While i < payload.Length
                    j = payload.IndexOfAny(reserved, i)
                    If j = -1 Then
                        UrlEncoded.Append(HttpUtility.UrlEncode(payload.Substring(i, payload.Length - i)))
                        Exit While
                    End If
                    UrlEncoded.Append(HttpUtility.UrlEncode(payload.Substring(i, j - i)))
                    UrlEncoded.Append(payload.Substring(j, 1))
                    i = j + 1
                End While
                SomeBytes = System.Text.Encoding.UTF8.GetBytes(UrlEncoded.ToString())
                request.ContentLength = SomeBytes.Length
                requestStream = request.GetRequestStream()

                requestStream.Write(SomeBytes, 0, SomeBytes.Length)
                requestStream.Close()
            End If
            response = request.GetResponse()

            Dim intPos0, intPos1, k, number As Integer

            Dim strHTMLText, strret As String


            streamReader = New System.IO.StreamReader(response.GetResponseStream())

            strHTMLText = streamReader.ReadToEnd


            intPos0 = strHTMLText.IndexOf("prnum", 0)
            If intPos0 > 1 Then
                intPos1 = strHTMLText.IndexOf("</b>", intPos0)


                strret = strHTMLText.Substring(intPos0, intPos1 - intPos0)
                intPos0 = 0
                intPos0 = strret.IndexOf("<b>", 0) + 3
                If intPos0 > 1 Then

                    strret = strret.Substring(intPos0)
                    For k = 0 To strret.Length - 1
                        If IsNumeric(strret.Substring(k, 1)) Then
                            number = number & strret.Substring(k, 1)
                        End If
                    Next
                End If
            Else
                number = 0
            End If

            BBDataPageRankLinkUpdate(strBBDataID, number)
            strReturn = "PageRank Index URL : " & strWebsiteIndexURL & " Page Rank : " & number.ToString


        Catch Exc As UriFormatException
            Console.WriteLine()
            Console.WriteLine("The request URI was malformed.")
        Catch Exc As WebException
            Console.WriteLine()
            Console.WriteLine("The request URI could not be found.")
        Catch Exc As IOException
            Console.WriteLine()
            Console.WriteLine("The request URI could not be retrieved.")
        Catch e As Exception
            Console.WriteLine(e.Message)
        Finally
            request.Abort()

            If requestStream IsNot Nothing Then
                requestStream.Dispose()
            End If
            If request IsNot Nothing Then
                request.Abort()
                request = Nothing
            End If

            If response IsNot Nothing Then
                response.Close()
            End If
            If streamReader IsNot Nothing Then
                streamReader.Close()
                streamReader.Dispose()
            End If

        End Try

        return $strReturn */
	}
	
	function GetScore($singleID="")
	{
		$bReturn = true;
        $strArgs = "-s";
        $this->WriteLog("Update Score started.");

		$dsDetails = $this->get_BBData_select($singleID);

		$i = 1;
		$iCount = sizeof($dsDetails);

		foreach($dsDetails as $row)
		{

            $intScore = "";
            $strPrice = "";
            $dblPrice = "";
		    $strWebsite = $row["WebsiteText"];
		    $strBBDataID = $row["BBDataId"];
            $intQuantcastCurrent = $row["QuantcastCurrent"];
            $intCompeteCurrent = $row["CompeteCurrent"];
            if(!is_null($row["Score"]))
                $intScore = $row["Score"];


            if(!is_null($row["Price"]) && !empty($row["Price"]))
			{
                $strPrice = $row["Price"];
                $dblPrice = str_replace('$', '', $strPrice);	//CDbl(strPrice)

                if (($dblPrice != 0) && ($dblPrice != 0.0))
				{
                    if($intQuantcastCurrent > $intCompeteCurrent)
					{
                        if($dblPrice > 0)
                            $intScore = $intQuantcastCurrent / $dblPrice;
					}
                    else
					{
                        If ($dblPrice > 0)
                            $intScore = $intCompeteCurrent / $dblPrice;
                    }
				}
                else
                    continue;
			}
            else
                $intScore = 0;

		    try
			{
		    	$strResult = $this->BBData_Score($intScore, $strBBDataID);

			    $this->WriteLog("[" . $i . " of " . $iCount . "] " . "ID = " . $strBBDataID . " Current Site = " . $strWebsite . " Score  = " . $intScore . " | Result = " . $strResult);
			}
		    catch(Exception $ex)
			{
		        $this->WriteLog("GetScore ERROR:: ID = " . $strBBDataID . " Current Site = " . $strWebsite . "\n" . $ex);
		        $bReturn = false;

		    }
		}

        $this->WriteLog("Update Score ended.\n");
        return $bReturn;
	}
	
	function BBData_Score($intScore, $BBDataId)
	{
        $bFinished = true;
		try
		{
			$sql = "UPDATE BBData
					SET Score = " . $intScore . "
					WHERE BBDataId = " . $BBDataId;
				
			if($this->config->item('app_debug') === true)
				$this->WriteLog($sql);

			$this->db->query($sql);
		}
		catch(Exception $ex)
		{
			$this->WriteLog("SQL ERROR::". $ex . " :: " . $sql);
            $bFinished = false;
		}

        return $bFinished;
	}
	
	function GetNoFollow($singleID="")
	{
		$bReturn = true;
        $strArgs = "-f";
        $strResult = "";
        $this->WriteLog("Update NoFollow started.");

		$dsDetails = $this->get_BBData_select($singleID);

		$i = 1;
		$iCount = sizeof($dsDetails);

		foreach($dsDetails as $row)
		{
		    $strWebsite = $row["WebsiteText"];
            $strWebsiteURL = $row["Website"];
            $strWebsiteIndexURL = $row["IndexPageURL"];
		    $strBBDataID = $row["BBDataId"];

            try
			{
                $strResult = $this->NoFollow($strWebsite, $strWebsiteURL, $strBBDataID, $strWebsiteIndexURL);

			    $this->WriteLog("[" . $i . " of " . $iCount . "] " . "ID = " . $strBBDataID . " Current Site = " . $strWebsite . " | Results = " . $strResult);
			}
            catch (Exception $ex)
			{
		        $this->WriteLog("NoFollow ERROR:: ID = " . $strBBDataID . " Current Site = " . $strWebsite . "\n" . $ex);
                $bReturn = false;
			}
        }

        $this->WriteLog("Update NoFollow ended.\n");
        return $bReturn;
	}
	
	function NoFollow($strWebsite, $strWebsiteURL, $strBBDataID, $strWebsiteIndexURL)
	{
		$strReturn = "";
		$strHTMLText = "";

        $strURL = $strWebsiteIndexURL;

		$strHTMLText = $this->Get_Live_Data($strURL);
		if(empty($strHTMLText))
			return "";

        $intPos0 = "";
		$intPos1 = "";
		$intPos2 = "";
        $strret = "";

        $intPos0 = strpos($strHTMLText, "nofollow", 0);
        if($intPos0 > 1)
		{
            $this->BBData_LinkType_Update($strBBDataID);
            $strReturn = "NoFollow URL : " . $strWebsiteURL;
        }

        return $strReturn;
	}
	
	function BBData_LinkType_Update($BBDataID)
	{
		try
		{
			$sql = "UPDATE BBData
					SET LinkType = 7
					WHERE BBDataId = " . $BBDataId;
				
			if($this->config->item('app_debug') === true)
				$this->WriteLog($sql);

			$this->db->query($sql);
		}
		catch(Exception $ex)
		{
			$this->WriteLog("SQL ERROR::". $ex . " :: " . $sql);
            $bFinished = false;
		}
	}
	
	function Get_Live_Data($strURL)
	{
		$strHTMLText = "";
		try
		{
  			$objWebRequest = curl_init(); //create a curl resource
			curl_setopt($objWebRequest, CURLOPT_URL, $strURL); //set the URL
			curl_setopt($objWebRequest, CURLOPT_RETURNTRANSFER, 1); //return the transfer as a string
			curl_setopt($objWebRequest, CURLOPT_TIMEOUT_MS, 600000); //set the timeout in millisecs

			$strHTMLText = curl_exec($objWebRequest); //get the page
			curl_close($objWebRequest); //close curl and tidy up
		}
		catch(Exception $ex)
		{
			$this-WriteLog("CURL ERROR:: " . $ex);
		}
		
		return $strHTMLText;
	}
	
	function get_BBData_select($BBDataID='')
	{
		$sql = "SELECT WebsiteText, Website, COALESCE(Quantified,0) as Quantified, QuantcastCurrent, QuantcastCurrentDataDate, QuantcastPrevious, QuantcastChange, CompeteCurrent, 
		        CompeteCurrentDataDate, CompetePrevious, CompeteChange, IndexByGoogle, IndexByMSN, IndexByYahoo, IndexPageURL, BBDataId, Score, Price,
				COALESCE(QuantcastCurrent,0) AS DBQuantcastCurrent, COALESCE(QuantcastPrevious,0) AS DBQuantcastPrevious, 
				COALESCE(CompeteCurrent,0) AS DBCompeteCurrent, COALESCE(CompetePrevious,0) AS DBCompetePrevious
				FROM BBData
				WHERE Enabled = 1";
		
		if(!empty($BBDataID))
		{
			if(strpos($BBDataID, ' AND ') !== false)
				$sql .= " AND BBDataID BETWEEN " . $BBDataID;
			else
				$sql .= " AND BBDataID = " . $BBDataID;
		}
		
		$results = $this->db->query($sql);
		return ($results->result_array());
	}
	
	function get_BBData_Count($range="")
	{
		$sql = "SELECT COUNT(*) AS count
				FROM BBData
				WHERE Enabled = 1";
		
		if(!empty($range))
		{
			if(strpos($range, ' AND ') !== false)
				$sql .= " AND BBDataID BETWEEN " . $range;
			else
				$sql .= " AND BBDataID = " . $range;
		}
		
		$query = $this->db->query($sql);

		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			$result = $row->count;
		}
		else
			$result = 0;

		return ($result);
	}
	
	function index_of_any($haystack, $needle_array)
	{
        for($i = 0,$z = count($needle_array); $i < $z; $i++)
		{
			if(strpos($haystack, $needle_array[$i]) !== false)
				return $i;
        }
        return false;
	}

	function add_date($givendate,$day=0,$mth=0,$yr=0)
	{
		$cd = strtotime($givendate);
	    $newdate = date('Y-m-d h:i:s', mktime(date('h',$cd),
	    date('i',$cd), date('s',$cd), date('m',$cd)+$mth,
	    date('d',$cd)+$day, date('Y',$cd)+$yr));
	    return $newdate;
	}
	
	function last_day_of_month($the_date)
	//$the_date assumed to be strtotime format (e.g. ’Y-m-d’)
	{
		date($the_date, strtotime('-1 second', strtotime('+1 month', strtotime(date('m').'/01/'.date('Y').' 00:00:00'))));
	}

	function formatTime($secs) 
	{
	   $times = array(3600, 60, 1);
	   $time = '';
	   $tmp = '';
	   for($i = 0; $i < 3; $i++) {
	      $tmp = floor($secs / $times[$i]);
	      if($tmp < 1) {
	         $tmp = '00';
	      }
	      elseif($tmp < 10) {
	         $tmp = '0' . $tmp;
	      }
	      $time .= $tmp;
	      if($i < 2) {
	         $time .= ':';
	      }
	      $secs = $secs % $times[$i];
	   }
	   return $time;
	}

	function fix_URL($strURL)
	{
		$strURL = str_replace("http://", "", $strURL);
		//$strURL = str_replace("?", "%3F", $strURL);
		//$strURL = str_replace(":", "%3A", $strURL);
		//$strURL = str_replace("/", "%2F", $strURL);
		//$strURL = str_replace("=", "%3D", $strURL);
		//$strURL = str_replace("&", "%26", $strURL);
		//$strURL = str_replace("+", "%2B", $strURL);

		return $strURL;
	}
	
	function WriteLog($info, $filename="/log/script.log")
	{ 
		$timestamp = date('m/d/Y H:i:s');
		
		//Open file
		$fd = fopen(constant('APP_LOG_BASE_PATH').$filename, "a+");

		//Write string
		fwrite($fd, $timestamp ." - ". $info . "\n");

		//Close file
		fclose($fd);
	}
	
	function ClearLog($filename="/log/script.log")
	{
		//Open file
		$fd = fopen(constant('APP_LOG_BASE_PATH').$filename, "r+");
		
		//Truncate the file
		ftruncate($fd, 0);
		
		//Close file
		fclose($fd);
	}

}

/* End of file admin_scripts.php */
/* Location: ./system/application/controllers/admin_scripts.php */