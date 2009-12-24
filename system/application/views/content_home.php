            <div id="Content">
                <div class="floatLeft">
                    <div class="headers">
                        <?=$web_sites?></div>
                    <div class="midArea" id="website"  style="padding-bottom:15px">
                        <table>
                            <?php foreach($query1->result_array() as $row):?>
                                    <tr>
                                        <td>
                                            <?=$row['ClassficationText']?>
                                        </td>
                                        <td style="padding-left: 7px;">
                                            <?=$row['ClassCount']?>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                        </table>
                    </div>
           
                </div>
                <div class="floatLeft">
                    <div class="headers">
                        <?=$free_sites?></div>
                    <div class="midArea" >
                        <table>
                            <?php foreach($query2->result_array() as $row):?>
                                    <tr>
                                        <td>
                                            <?=$row['PriceTypeText']?>
                                        </td>
                                        <td style="padding-left: 7px;">
                                            <?=$row['PriceTypeCount']?>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                        </table>
                    </div> 
                </div>
                <div class="floatLeft">
                    <div class="headers">
                        <?=$local_sites?></div>
                    <div class="midArea" style="padding-bottom:15px" id="Div1"> 
                    <table  cellpadding="0" width ="150px" cellspacing="0">
                      <?php for($i=0,$j=26; $i<26; $i++,$j++):?>
					  <?php $left = $query3->result_array[$i];
					  		if($j < $query3->num_rows()) 
					  			$right = $query3->result_array[$j];
							else
								$right = array('StatesCode'=>'','StateCount'=>''); 
						?>
                        <tr>
                            <td style="text-align: left; width: 30px;">
                                <?php  echo substr($left['StatesCode'],0,2);?></td>
                            <td style="text-align: right; width: 15px;">
                                <?php echo $left['StateCount'];?></td>
                            <td style="width: 50px;">&nbsp;
                                
                            </td>
                              <td style="text-align: left; width: 30px;">
                                <?php echo substr($right['StatesCode'],0,2);?></td>
                            <td style="text-align: right; width: 15px;">
                                <?php echo $right['StateCount'];?></td>
                        </tr>
						<?php endfor;?>
                    </table>
                    </div>
                </div>
                <div class="floatRight">
                    <div class="headers">
                        Rating System</div>
                    <div class="mid">
                        <div class="clear">
                        </div>
                        
                        <div>
                            <table width="200px" cellpadding="0" cellspacing="0">
                                <?php foreach($query4->result_array() as $row):?>
								<?php $img = '';
										$rating = $row['Rating'];
										If(($rating == 0) && !is_null($rating))
											$img = img('images/star-o.gif');
										else
										{
											if($rating > 0)
											{
												for($i=1; $i<=$rating; $i++)
													$img .= img('images/star.gif').'&nbsp;';
											}
											else
											{
												$img = img('images/nr.gif');
											}
										}
								?>
                                        <tr>
                                            <td style="text-align: right; width: 160px;">
                                                <?=$img?>
                                            </td>
                                            <td style="text-align: right; width: 40px;">
                                                <?=$row['RatingCount']?>
                                            </td>
                                        </tr>
                                    <?php endforeach;?>
                             </table>
                        </div>
                        <div class="rating">
                          4 Stars is our highest rating.  An asterisk <?= img('images/star-o.gif'); ?> indicates PPC or commission and&nbsp;
                            <?= img('images/nr.gif'); ?>&nbsp; means &ldquo;Not Rated.&rdquo;
						</div>
                        <br />
                        <div class="clear">
                        </div>
                    </div>
                </div>
                <div class="clear">
                </div>
            </div>
