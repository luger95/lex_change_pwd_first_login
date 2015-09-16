<?php

namespace Contao;

class CpflPostLogin extends \PageRegular 
{
	public function postLogin(FrontendUser $objUser)
	{
	   	if($objUser->pwChange === '1')
	   	{
			$confirmationId = md5(uniqid(mt_rand(), true));

			// Store the confirmation ID
			$objMember = \MemberModel::findByPk($objUser->id);
			$objMember->activation = $confirmationId;
			$objMember->save();

			// Prepare the simple token data
			/*$arrData = $objMember->row();
			$arrData['domain'] = \Idna::decode(\Environment::get('host'));
			$arrData['link'] = \Idna::decode(\Environment::get('base')) . \Environment::get('request') . ((\Config::get('disableAlias') || strpos(\Environment::get('request'), '?') !== false) ? '&' : '?') . 'token=' . $confirmationId;*/

			// Send e-mail
			/*$objEmail = new \Email();

			$objEmail->from = $GLOBALS['TL_ADMIN_EMAIL'];
			$objEmail->fromName = $GLOBALS['TL_ADMIN_NAME'];
			$objEmail->subject = sprintf($GLOBALS['TL_LANG']['MSC']['passwordSubject'], \Idna::decode(\Environment::get('host')));
			$objEmail->text = \StringUtil::parseSimpleTokens($this->reg_password, $arrData);
			$objEmail->sendTo($objMember->email);*/

			$this->log('A new password has been requested for user ID ' . $objMember->id . ' (' . $objMember->email . ')', __METHOD__, TL_ACCESS);

			if($GLOBALS['_GET']['language'] == 'fr')
			{
				$arrPage = \PageModel::findByPk(223)->current()->row();				
			}
			elseif($GLOBALS['_GET']['language'] == 'de')
			{
				$arrPage = \PageModel::findByPk(209)->current()->row();
			}

			$url = $this->generateFrontendUrl($arrPage)."?token=$confirmationId";
			$this->redirect($url);
	   	}
	}

	public function mySetNewPassword($objUser, $strPassword)
	{
	    \Database::getInstance()->prepare("UPDATE `tl_member` SET pwChange=0 WHERE id = ?")->execute($objUser->id);
	}
}