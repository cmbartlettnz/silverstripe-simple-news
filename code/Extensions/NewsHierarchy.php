<?php
/**
 * Created by Nivanka Fonseka (nivanka@silverstripers.com).
 * User: nivankafonseka
 * Date: 4/6/15
 * Time: 3:07 PM
 * To change this template use File | Settings | File Templates.
 */

class NewsHierarchy extends Hierarchy {

	public function getChildrenAsUL($attributes = "", $titleEval = '"<li>" . $child->Title', $extraArg = null,
									$limitToMarked = false, $childrenMethod = "AllChildrenIncludingDeleted",
									$numChildrenMethod = "numChildren", $rootCall = true,
									$nodeCountThreshold = null, $nodeCountCallback = null) {


		if(get_class($this->owner) == 'NewsIndex'){
			$strURL = $this->owner->getNewsItemsEditLink();
			$output = "<ul$attributes>\n";
			$output.= '<li class="readonly">
				<a class="cms-panel-link" data-pjax-target="Content" href="' . $strURL . '">' . $this->owner->getTreeEditLinkText() .  '</a>
			</li>';
			$output.= "</ul>";
			return $output;
		}
		else{
			return parent::getChildrenAsUL($attributes, $titleEval, $extraArg, $limitToMarked, $childrenMethod, $numChildrenMethod,
				$rootCall, $nodeCountThreshold, $nodeCountCallback);
		}
	}
	
	public function loadDescendantIDListInto(&$idList) {
		if($children = $this->AllChildren()) {
			foreach($children as $child) {
				if(in_array($child->ID, $idList)) {
					continue;
				}
				$idList[] = $child->ID;
				$ext = $child->getExtensionInstance('NewsHierarchy');
				$ext->setOwner($child);
				$ext->loadDescendantIDListInto($idList);
				$ext->clearOwner();
			}
		}
	}

} 