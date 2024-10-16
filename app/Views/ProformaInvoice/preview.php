<!DOCTYPE html>
<html lang="en">
<head>
	<?= $this->include('partials/title-meta') ?>
	<?= $this->include('partials/head-css') ?>
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/assets/css/print_report.css"> 
    <style>
        @media print {
            .printableArea { 
                display: block;
            } 
        }
		.b-bt-none{
			border-bottom: none !important;
		}
		.b-lt1{
			border-left: 1pt solid #221E1F;
		}
		.b-tp1{
			border-top: 1pt solid #221E1F
		}
		.b-tp-none{
			border-top: none !important;
		}
		.b-rt1{
			border-right: 1pt solid #221E1F;
		}
    </style>
</head>
<body>
	<!-- Main Wrapper -->
	<div class="main-wrapper">
		<?= $this->include('partials/menu') ?>
		<!-- Page Wrapper -->
		<div class="page-wrapper">
			<div class="content">
				<div class="row">
					<div class="col-md-12"> 
						<div class="row">
							<div class="col-xl-12 col-lg-12">
								<!-- Settings Info -->
								<div class="card">
									<div class="card-body">
										<div class="settings-form"> 
                                            <div class="settings-sub-header">
                                                <h4>Preview Proforma Invoice</h4>
                                            </div> 
                                            <div class="profile-details">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="col-form-label"><b>Proforma Invoice No.: </b></label>
                                                        <label class="col-form-label"><?= $proforma_invoice['proforma_invoices_no'] ?></label>
                                                    </div>

													<div class="col-md-6">
                                                        <label class="col-form-label"><b>Booking No.: </b></label>
                                                        <label class="col-form-label"><?= $proforma_invoice['booking_number'] ?></label>
                                                    </div>

													<div class="col-md-6">
                                                        <label class="col-form-label"><b>Customer Name: </b></label>
                                                        <label class="col-form-label"><?= $proforma_invoice['party_name'] ?></label>
                                                    </div>

													<div class="col-md-6">
                                                        <label class="col-form-label"><b>Commission Agent: </b></label>
                                                        <label class="col-form-label"><?= $proforma_invoice['customer_party_name'] ?></label>
                                                    </div>

													<div class="col-md-6">
                                                        <label class="col-form-label"><b>Freight Charges: </b></label>
                                                        <label class="col-form-label"><?= 'Rs.'.number_format($proforma_invoice['total_freight'],2) ?></label>
                                                    </div>

													<div class="col-md-6">
                                                        <label class="col-form-label"><b>Other Expenses: </b></label>
                                                        <label class="col-form-label"><?= 'Rs.'.number_format($proforma_invoice['other_expenses'],2) ?></label>
                                                    </div>

													<div class="col-md-6">
                                                        <label class="col-form-label"><b>Invoice Amount: </b></label>
                                                        <label class="col-form-label"><?= 'Rs.'.number_format($proforma_invoice['invoice_total_amount'],2) ?></label>
                                                    </div>

                                                </div>
                                                <br>
                                            </div> 
                                            <div class="submit-button"> 
											<button type="button" class="btn btn-danger" onclick="printDiv('printableArea')"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                                                <a href="<?php echo base_url().$currentController; ?>" class="btn btn-light">Cancel</a>
                                            </div>  

											<div class="card" id="printableArea" style="display: none;">
											<div class="card-body">
											<table cellspacing="0" id="printTable" class="print-table">
												<tbody> 
													<tr style="height:77pt"> 
														<td colspan="8" class="td-head">
															<table border="0" cellspacing="0" cellpadding="0">
																<tbody>
																	<tr>
																		<td>
																			<img width="105" height="47" src="<?php echo base_url(); ?>public/assets/img/logo.png">
																		</td>
																		<td>
																			<p class="s1 txt-center mh"> 
																				GAE CARGO MOVERS PRIVATE LIMITED 
																			</p>
																		</td>
																	</tr>
																</tbody>
															</table> 
															<p class="sub-headerpr">
																A-131/2, 2nd Floor, Wazirpur Industrial Area, Delhi- 110052
															</p>
															<p class="sub-headerpr">
																<a href="mailto:gaecargo21@yahoo.com" class="s4" target="_blank">
																	Mobile : 7669027900, EMail :booking@gaegroup.in
																</a>
															</p> 
															<p class="sub-headerpr">
																<span>PAN NO - AAICG9037G</span> &nbsp;
																<span>GSTIN - 07AAICG9037G1ZF</span> <br/>
																<span>CIN - U63030DL2021PTC378353</span> &nbsp;
																<span>MSME - UDYAM-DL-06-0016237</span>
															</p>
														</td>
													</tr>
													<tr style="height:21pt">
														<td class="s6td" colspan="8">
															<p class="s6 p13 txt-center">
																<span class="s7">PROFORMA &nbsp;INVOICE</span>
															</p>
														</td>
													</tr>
													
													<tr style="height:21pt"> 
														<td class="td27" colspan="3" rowspan="5">
															<p class="s10 p14"><?= $proforma_invoice['party_name'] ?></p>
															<p class="s10 p14"><?= $proforma_invoice['business_address'] ?></p>
															<p class="s10 p14"><?= $proforma_invoice['city'] .', '.$proforma_invoice['state_name'] .'-'.$proforma_invoice['postcode'] ?></p>
															<p class="s10 p14" >CONTACT PERSON:- <?= $proforma_invoice['contact_person'] ?></p>
														</td> 
														<td class="td29" colspan="5">
															<p class="s10 p14" >NO - <?= $proforma_invoice['proforma_invoices_no'] ?> </p>
														</td>
														
													</tr>
													<tr style="height:21pt">  
														<td  class="td33" colspan="5">
															<p class="s10" style="text-indent: 0pt;line-height: 212%;text-align: left;">Date - <?= date('d M Y',strtotime($proforma_invoice['created_at'])) ?></p> 
														</td>
													</tr>
													<tr style="height:21pt">  
														<td  class="td33" colspan="5">
															<div class="s10" style="float: left;width: 63%;">
																BOOKING NUMBER - <?= $proforma_invoice['booking_number'] ?>
															</div>
															<div class="s10">BOOKING DATE - <?= date('d M Y',strtotime($proforma_invoice['booking_date'])) ?></div>
															<!-- <p class="s10" style="text-indent: 0pt;line-height: 212%;text-align: left;">BOOKING NUMBER - <?= $proforma_invoice['booking_number'] ?></p>  -->
														</td>
													</tr> 
													<tr style="height:21pt">  
														<td  class="td33" colspan="5">
															<div class="s10" style="float: left;width: 55%;">
															   CONSIGNMENT NO. - <?= $proforma_invoice['consignment_no'] ?>
															</div>
															<div class="s10">CONSIGNMENT DATE - <?= date('d M Y',strtotime($proforma_invoice['consignment_date'])) ?></div>
														</td>
													</tr> 
													<tr style="height:21pt">  
														<td  class="td33" colspan="5">
															<p class="s10" style="text-indent: 0pt;line-height: 212%;text-align: left;">VEHICLE NO - <?= $proforma_invoice['rc_number'] ?></p> 
														</td>
													</tr>

													<tr style="height:21pt"> 
														<td class="td27" colspan="3">
															<p class="s10 p14" >EMAIL:- <?= $proforma_invoice['email'] ?></p>
														</td> 
														<td class="td29" colspan="5">
															<p class="s10 p14" >PICKUP PLACE - <?= $proforma_invoice['pickup_state'] ?></p>
														</td>
													</tr>

													<tr style="height:21pt"> 
														<td class="td27" colspan="3">
															<p class="s10 p14" >MOBILE:- <?= $proforma_invoice['primary_phone'] ?></p>
														</td> 
														<td class="td29" colspan="5">
															<p class="s10 p14" >PLACE OF DESTINATION - <?= $proforma_invoice['drop_state'] ?></p>
														</td>                                                
													</tr> 

													<tr style="height:21pt"> 
														<td class="td27" colspan="3">
														<p class="s10 p14" >GSTIN:- <?= isset($party_doc['gst']) && ($party_doc['gst'] != '') ? $party_doc['gst'] : '-' ?></p>
														</td> 
														<td class="td29" colspan="5">
															<p class="s10 p14" >ACTUAL WEIGHT- <?= ($proforma_invoice['actual_weight'] >0) ? number_format($proforma_invoice['actual_weight'],2).' KG' : 0 .' KG' ?></p>
														</td>
													</tr> 
													<?php if($proforma_invoice['bc_id'] != $proforma_invoice['pid']){ ?>
													<tr style="height:21pt"> 
														<td class="td27" colspan="3">
														<p class="s10 p14" >-</p>
														</td> 
														<td class="td29" colspan="5">
															<p class="s10 p14" >COMMISSION AGENT - <?= ($proforma_invoice['customer_party_name'] != '') ? ucwords(strtolower($proforma_invoice['customer_party_name'])) : ' -' ?></p>
														</td>
													</tr> 
													<?php } ?>

													<tr style="height:11pt">
														<td  class="td34"  style="width:20px !important;">
															<p class="s9 p12">S.NO.</p>
														</td>
														<td  class="td35">
															<p class="s9 p16">Particulars</p>
														</td>
														<td  class="td36" >
															<p class="s9 p16" >HSN CODE</p>
														</td>
														<td  class="td36" >
															<p class="s9 p16" >CHARGE TYPE</p>
														</td>
														<td  class="td37" >
															<p class="s9 p12" style="padding-left: 3pt;">NO. OF BOXES</p>
														</td>
														<td  class="td36" >
															<p class="s9 p16" >CHARGED WT(KGS)</p>
														</td>
														<td  class="td38" >
															<p class="s9 p16" >Price</p>
														</td>
														<td  class="td39" >
															<p class="s9 p16" >Amount</p>
														</td>
													</tr>
													<tr style="height:21pt">
														<td  class="td40" >
															<p class="s10" style="width:10px !important;padding-left: 22pt;padding-right: 2pt;text-indent: -19pt;line-height: 10pt;text-align: left;">1.</p>
														</td>
														<td class="td41" >
															<p class="s10 p11" style="width:200px !important;"><?= ($proforma_invoice['particulars']) ? $proforma_invoice['particulars'] : '-' ?></p>
														</td>
														<td class="td42" >
															<p class="s10 p11"><?= ($proforma_invoice['hsn_code']) ? $proforma_invoice['hsn_code'] : '-' ?></p>
														</td>
														<td class="td41" >
															<p class="s10 p11" style="width:80px !important;">Freight Charges</p>
														</td>
														<td class="td43" >
															<p class="s10 p11" ><?= ($proforma_invoice['no_of_packages'] >0) ? $proforma_invoice['no_of_packages'] : '0' ?></p>
														</td>
														<td class="td43" >
															<p class="s10 p11" ><?= ($proforma_invoice['charge_weight'] >0) ? number_format($proforma_invoice['charge_weight'],2) : '0' ?></p>
														</td>
														<td class="td44" >
															<p class="s10 p11" ><?= number_format($proforma_invoice['total_freight'],2) ?></p>
														</td>
														<td class="td45" style="width: 5% !important;">
															<p class="s10 p11" ><?= number_format($proforma_invoice['total_freight'],2) ?></p>
														</td>
													</tr>
													<?php 
													if(!empty($booking_expences)){
														foreach($booking_expences as $k=>$booking_expence){ ?>
															<tr style="height:11pt">
																<td class="<?= (count($booking_expences) == $k+1) ? 'td46 b-tp-none' : 'b-bt-none b-lt1'?>" colspan="7">
																	<p class="s10 p12 prtds10"><?= ($booking_expence['head_name']) ? ucfirst($booking_expence['head_name']) : '' ?></p>
																</td> 
																<td class="<?= (count($booking_expences) == $k+1) ? 'td48 b-tp-none' : 'b-bt-none b-lt1 b-rt1'?>" colspan="1">
																	<p class="s11 p12 fntb" style="padding-left: 44pt;"><?= $booking_expence['value'] ?></p>
																</td>
															</tr> 
														<?php }
													}
													?>
													<?php if(isset($is_tax_applicable['cnt']) && ($is_tax_applicable['cnt'] > 0)){ ?>			
													<?PHP if($proforma_invoice['sgst_percent'] >0){ ?>											
													<tr style="height:11pt">
														<td class="b-bt-none b-lt1" colspan="7">
															<p class="s10 p12 prtds10">SGST @ <?= ($proforma_invoice['sgst_percent'] >0) ? number_format($proforma_invoice['sgst_percent'],2) : 0 ?>%</p>
														</td> 
														<td class="b-bt-none b-rt1 b-lt1" colspan="1">
															<p class="s11 p12 fntb" style="padding-left: 44pt;"><?= ($proforma_invoice['sgst_total'] >0) ? number_format($proforma_invoice['sgst_total'],2) : 0 ?></p>
														</td>
													</tr> 
													<?PHP if($proforma_invoice['cgst_percent'] >0){ ?>
													<?php } ?>  
													<tr style="height:11pt">
														<td class="b-bt-none b-lt1" colspan="7">
															<p class="s10 p12 prtds10">CGST @ <?= ($proforma_invoice['cgst_percent'] >0) ? number_format($proforma_invoice['cgst_percent'],2) : 0 ?>%</p>
														</td> 
														<td class="b-bt-none b-rt1 b-lt1" colspan="1">
															<p class="s11 p12 fntb" style="padding-left: 44pt;"><?= ($proforma_invoice['cgst_total'] >0) ? number_format($proforma_invoice['cgst_total'],2) : 0 ?></p>
														</td>
													</tr> 
													<?php } ?>  
													<?PHP if($proforma_invoice['igst_percent'] >0){ ?>
													<tr style="height:11pt">
														<td class="b-bt-none b-lt1" colspan="7">
															<p class="s10 p12 prtds10">IGST @ <?= ($proforma_invoice['igst_percent'] >0) ? number_format($proforma_invoice['igst_percent'],2) : 0 ?>%</p>
														</td> 
														<td class="b-bt-none b-rt1 b-lt1" colspan="1">
															<p class="s11 p12 fntb" style="padding-left: 44pt;"><?= ($proforma_invoice['igst_total'] >0) ? number_format($proforma_invoice['igst_total'],2) : 0 ?></p>
														</td>
													</tr> 
													<?php } ?>  
													<?php } ?>
													<tr style="height:11pt">
														<td class="td46" colspan="7">
															<p class="s10 p12 prtds10">Total Invoice Value</p>
														</td> 
														<td class="td48" colspan="1">
															<?php $total = $proforma_invoice['total_freight']+ $proforma_invoice['sgst_total'] + $proforma_invoice['cgst_total']  +$proforma_invoice['igst_total'] ;?>
															<?php $invoice_total = ($proforma_invoice['invoice_total_amount'] > 0) ? $proforma_invoice['invoice_total_amount'] : 0;?>
															<p class="s11 p12 fntb" style="padding-left: 44pt;"><?= number_format($invoice_total,2) ?></p>
														</td>
													</tr>  
													<!-- <tr style="height:11pt">
														<td class="td34" colspan="8">
															<table border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td class="profotd34">Tax Rate</td>
																	<td class="profotd34">Taxable Amt.</td>
																	<td class="profotd34">SGST</td>
																	<td class="profotd34">IGST</td>
																	<td class="profotd34">CGST</td>
																	<td class="profotd34">Total Tax</td>
																</tr>
																<tr>
																	<td class="profotd34"></td>
																	<td class="profotd34"><?= $proforma_invoice['total_freight'] ?></td>
																	<td class="profotd34">0</td>
																	<td class="profotd34">0</td>
																	<td class="profotd34">0</td>
																	<td class="profotd34">0</td>
																</tr>
																<tr>
																	<td class="profotd34">Amount (in words)</td>
																	<?php $amount = ($proforma_invoice['total_freight'] > 0) ? $proforma_invoice['total_freight'] : 0; ?>
																	<td colspan="5" class="profotd34">Rs. <?= convert_number_to_words($amount) ?> Only</td>
																</tr>
															</table>
														</td>
													</tr> -->
													<tr style="height:11pt">
														<td class="td34" colspan="8">
															<table border="0" cellspacing="0" cellpadding="0" style="width: 100%;"> 
																<tr>
																	<td class="profotd34" style="max-width: 25px;">Amount (in words): </td>
																	<?php $amount = ($proforma_invoice['total_freight'] > 0) ? $proforma_invoice['total_freight'] : 0; ?>
																	<td class="profotd34">Rs. <?= convert_number_to_words($invoice_total) ?> Only</td>
																</tr>
															</table>
														</td>
													</tr> 
													<tr style="height:11pt"> 
														<td class="td34">
															<p class="s9 p12" style="padding-left: 24pt;">Bank Detail:</p>
														</td>
														<td class="td52" colspan="7">
															<p class="s9" style="padding-left: 10pt;padding-right: 28pt;text-indent: 0pt;line-height: 9pt;">
															Bank Name:ICICI Bank
															</p>
															<p class="s9" style="padding-left: 10pt;padding-right: 28pt;text-indent: 0pt;line-height: 9pt;">
															Branch Name: BG-221, SANJAY GANDHI TRANSPORT NAGAR, DELHI - 110042
															</p>
															<p class="s9" style="padding-left: 10pt;padding-right: 28pt;text-indent: 0pt;line-height: 9pt;">
															A/C NO: 723505000148
															</p>
															<p class="s9" style="padding-left: 10pt;padding-right: 28pt;text-indent: 0pt;line-height: 9pt;">
															IFSC: ICIC0007235
															</p>
														</td>
													</tr>
		
													<tr style="height:59pt">                                                
														<td colspan="5" rowspan="2"  class="td63">
															<p class="s9 pdl12 pdl8">
															Terms & Conditions:  
															</p> 
															<p class="s9 pdl12 pdl8"> 
															1.Description of service : Transport of Goods by Road <br/>
															2.The Total Freight Charges have been agreed an represent the Total Amount Due and Payable to GAE Cargo & Movers Pvt Ltd without any deductions on any account whatsoever.<br/>
															3.Advance against Freight Charges, as agreed, shall be required to be paid within 24 hours from truck load.<br/>
															</p> 
														</td>
														<td colspan="5" class="td63">
															<p class="s9 pdl12 pdl8">
															Receiver's Signature:  
															</p> 
														</td>
													
													</tr>
													<tr style="height:45pt">
														<td colspan="5" class="td64">
															<p class="s9 p17 mrg-tp5">
																For GAE CARGO MOVERS PRIVATE LIMITED</p>
															<p class="p18"><span></span></p>
															<table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
																<tbody>
																	<tr>
																		<td style="text-align: center;">
																			<img width="105" height="70" src="<?php echo base_url(); ?>public/assets/img/print-consignment-sign.png">
																		</td>
																	</tr>
																</tbody>
															</table>
															<p></p>
															<p class="s9 p17">
																SIGNATURE OF THE ISSUING OFFICE
															</p>
														</td>
													</tr>
													<tr style="height:11pt">
														<td class="td52" colspan="8">
															<p class="s9" style="padding-left: 10pt;padding-right: 28pt;text-indent: 0pt;line-height: 9pt;">
																Remarks:
															</p>
														</td>
													</tr>

												</tbody>
											</table> 
											</div>
										</div>
										
										</div>
									</div>
								</div>
								<!-- /Settings Info -->

							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
		<!-- /Page Wrapper -->
		<input type="hidden" id="proforma_invoices_no" value="<?= str_replace('/','-',$proforma_invoice['proforma_invoices_no']) ?>" />
	</div>
	<!-- /Main Wrapper -->

	<?= $this->include('partials/vendor-scripts') ?> 
	<script>
        function printDiv(divId) {
            var printContents = document.getElementById(divId).innerHTML;
            var originalContents = document.body.innerHTML;
			document.title = $('#proforma_invoices_no').val();
            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
</body>

</html>