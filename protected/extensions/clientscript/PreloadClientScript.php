<?php
/**
 * preload javascript and not use assets
 * @author tinghe
 */
class PreloadClientScript extends CClientScript{
	var $disableAssets = true;
	public function registerCoreScript($sName)
	{
	   if ($this->disableAssets) {
	      return $this;
	   }
	   return parent::registerCoreScript($sName);
	}
}