function client_select_many($Website, $Classification, $PriceType, $BBSpecials, $UserReview, $Google, $Yahoo, $MSN, $Quantified, $Rating, $State, $LinkType, $AdPackage, $BBCategory, $MaxPR, $LinkPR, $Limited)
	{

		if($Limited !== '')
		{
			$sql = 'SELECT DISTINCT TOP ' . $Limited;
		} else {
			$sql = 'SELECT DISTINCT';
		}

		$sql .= ' BBData.BBDataID, BBData.LastUpdated, BBData.QuantcastCurrent, BBData.QuantcastChange, BBData.CompeteCurrent, 
				BBData.CompeteChange, BBData.Rating, BBData.WebSiteText, BBData.WebSite, Classification.ClassficationText, BBData.Score, 
				BBData.Price, BBData.BBCategory, BBData.LinkPR, BBData.MaxPR, LinkType.LinkTypeText as LinkType, AdPackage.AdPackageText as AdPackage, 
				BBData.Quantified, BBData.IndexByYahoo, BBData.IndexByMSN, BBData.IndexByGoogle, PriceType.PriceTypeText AS PriceType
				FROM BBData 
				LEFT OUTER JOIN Classification ON BBData.Classification = Classification.ClassficationID 
				LEFT OUTER JOIN LinkType ON BBData.LinkType= LinkType.LinkTypeID 
				LEFT OUTER JOIN PriceType ON BBData.PriceType = PriceType.PriceID 
				LEFT OUTER JOIN AdPackage ON BBData.AdPackage= AdPackage.AdPackageID 
				LEFT OUTER JOIN StatesServed ON BBData.BBDataId = StatesServed.BBDataId
				WHERE (BBData.Enabled = 1)';

		if($Rating !== '')
		{
			$sql .= ' AND COALESCE(BBData.Rating,-1) IN (' . $Rating . ')';
		}		
		
		
		if($LinkPR !== '')
		{
			$sql .= ' AND COALESCE(BBData.LinkPR,0) IN (' . $LinkPR . ')';
		}		
		
	
		if($MaxPR !== '')
		{
			$sql .= ' AND COALESCE(BBData.MaxPR,0) IN (' . $MaxPR . ')';
		}		
		
		if($Quantified !== '')                                          
		{
			$sql .= ' AND BBData.Quantified LIKE \'' . $Quantified . '%\'';
		}

		if($BBSpecials !== '')
		{
			$sql .= ' AND BBData.BBListSpecials LIKE \'' . $BBSpecials . '%\'';
		}
		
		if($Yahoo !== '')
		{
			$sql .= ' AND BBData.IndexByYahoo LIKE \'' . $Yahoo . '%\'';
		}
		
	
		if($BBCategory !== '')
		{
			$sql .= ' AND BBData.BBCategory = ' . $BBCategory . '';
		}
		
		if($MSN !== '')
		{
			$sql .= ' AND BBData.IndexByMSN LIKE \'' . $MSN . '%\'';
		}
		
		if($Google !== '') 
		{
			$sql .= ' AND BBData.IndexByGoogle LIKE \'' . $Google . '%\'';
		}
		
		if($UserReview !== '')
		{
			$sql .= ' AND BBData.UserReview LIKE \'' . $UserReview . '%\'';
		}
		
		if($PriceType !== '')     
		{
			if($PriceType !== 'Blank')
			{
				$sql .= ' AND BBData.PriceType LIKE \'' . $PriceType . '%\'';
			} else {
				$sql .= ' AND BBData.PriceType IS NULL';
			}
		}

		if($LinkType !== '')     
		{
			$sql .= ' AND BBData.LinkType = ' . $LinkType . '';
		}

		if($AdPackage !== '')     
		{
			$sql .= ' AND BBData.AdPackage = ' . $AdPackage . '';
		}
		
		if($Website === '')
		{
			if($Classification !== '')    
			{
				if($Classification !== 'Blank')
				{
					$sql .= ' AND BBData.Classification IN (' . $Classification . ')';
				} else {
					$sql .= ' AND BBData.Classification IS NULL';
				}
			 }
	
			if($State !== '')
			{
				if($State !== 'Blank')
				{
					$sql .= ' AND BBData.BBDataId IN(SELECT DISTINCT BBDataID FROM StatesServed WHERE StatesServed.StateServed LIKE \'' . $State . '\')';
				} else {
					$sql .= ' AND BBData.BBDataId NOT IN(SELECT DISTINCT BBDataID FROM StatesServed WHERE NOT StateServed IS NULL )';
				}
			}
		}

		if($Website !== '')  
		{
			$sql .= ' AND BBData.WebsiteText LIKE \'' . $Website . '%\'';
		}
		
		$sql .= ' ORDER BY BBData.LastUpdated Desc';
		
//print $sql;
			
		return ($this->db->query ($sql));

	}
	
	function new_one($Website, $Classification, $PriceType, $BBSpecials, $UserReview, $Google, $Yahoo, $MSN, $Quantified, $VacationRental, $Rating, $Limited, $UserName, $LinkPR, $BBCategory, $LinkType, $sort_column, $sort_direction)
	{
		
		$MaxPR = '';
		$AdPackage = '';
		$State = '';

		if($Limited !== '')
			$sql = 'SELECT DISTINCT TOP ' . $Limited;
		else
			$sql = 'SELECT DISTINCT';
		
		$sql .= ' BBData.BBDataID, BBData.LastUpdated, BBData.QuantcastCurrent, BBData.QuantcastChange, BBData.CompeteCurrent, BBData.CompeteChange, BBData.Rating, BBData.WebSiteText, BBData.WebSite, Classification.ClassficationText, BBData.Score, BBData.Price, BBData.BBCategory, BBData.LinkPR, BBData.MaxPR, LinkType.LinkTypeText as LinkType, AdPackage.AdPackageText as AdPackage , BBData.Quantified, BBData.IndexByYahoo, BBData.IndexByMSN, BBData.IndexByGoogle, PriceType.PriceTypeText AS PriceType
				FROM BBData LEFT OUTER JOIN
				Classification ON BBData.Classification = Classification.ClassficationID LEFT OUTER JOIN
				LinkType ON BBData.LinkType= LinkType.LinkTypeID LEFT OUTER JOIN
				PriceType ON BBData.PriceType = PriceType.PriceID LEFT OUTER JOIN
				AdPackage ON BBData.AdPackage= AdPackage.AdPackageID LEFT OUTER JOIN
				StatesServed ON BBData.BBDataId = StatesServed.BBDataId
				WHERE (BBData.Enabled = 1)';
	
		if($Rating !== '')
			$sql .= ' AND isnull(BBData.Rating,-1) IN (' . $Rating . ')';

		if($LinkPR !== '')
			$sql .= ' AND isnull(BBData.LinkPR,0) IN (' . $LinkPR . ')';

		if($MaxPR !== '')
			$sql .= ' AND isnull(BBData.MaxPR,0) IN (' . $MaxPR . ')';
		
		if($Quantified !== '')
			$sql .= ' AND BBData.Quantified LIKE \'' . $Quantified . '%\'';

		if($BBSpecials !== '')
			$sql .= ' AND BBData.BBListSpecials LIKE \'' . $BBSpecials . '%\'';
		
		if($Yahoo !== '')
			$sql .= ' AND BBData.IndexByYahoo LIKE \'' . $Yahoo . '%\'';		
	
		if($BBCategory !== '')
			$sql .= ' AND BBData.BBCategory = ' . $BBCategory;
		
		if($MSN !== '')
			$sql .= ' AND BBData.IndexByMSN LIKE \'' . $MSN . '%\'';
		
		if($Google !== '')
			$sql .= ' AND BBData.IndexByGoogle LIKE \'' . $Google . '%\'';
		
		if($UserReview !== '')
			$sql .= ' AND BBData.UserReview LIKE \'' . $UserReview . '%\'';
		
		if($PriceType !== '')
		{
		if($PriceType !== 'Blank')
			{
				$sql .= ' AND BBData.PriceType LIKE \'' . $PriceType . '%\'';
			}
			else
			{
				$sql .= ' AND BBData.PriceType is Null';
			}
		}

		if($LinkType !== '')
			$sql .= ' AND BBData.LinkType = ' . $LinkType;

		if($AdPackage !== '')
			$sql .= ' AND BBData.AdPackage = ' . $AdPackage;
		
		if($Website  === '')
		{
			if($Classification !== '')   
				{
					if($Classification !== 'Blank')
					{
						$sql .= ' AND BBData.Classification In (' . $Classification . ')';
					}
					else
					{
						$sql .= ' AND BBData.Classification is Null';
					}
				}
	
			if($State !== '')
				{
	
				if($State !== 'Blank')
					{
						$sql .= ' AND BBData.BBDataId IN(SELECT DISTINCT BBDataID FROM StatesServed WHERE StatesServed.StateServed LIKE \'' . $State . '\')';
					}
				else
					{
						$sql .= ' AND BBData.BBDataId NOT IN(SELECT DISTINCT BBDataID FROM StatesServed WHERE Not StateServed is null )';
					}
				}
		}
		
		$sql .= ' ORDER BY ';

		$sql .= $sort_column . ' ' . $sort_direction;

print $sql;
			
		return ($this->db->query ($sql));

	}