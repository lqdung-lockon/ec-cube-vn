<?php
/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2007 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

// {{{ requires
require_once(CLASS_PATH . "pages/LC_Page.php");

/**
 * アプリケーション管理:インストールログ のページクラス.
 *
 * @package Page
 * @author LOCKON CO.,LTD.
 * @version $Id$
 */
class LC_Page_Admin_OwnersStore_Log extends LC_Page {

    // }}}
    // {{{ functions

    /**
     * Page を初期化する.
     *
     * @return void
     */
    function init() {
        parent::init();

        $this->tpl_mainpage = 'ownersstore/log.tpl';
        $this->tpl_subnavi  = 'ownersstore/subnavi.tpl';
        $this->tpl_mainno   = 'ownersstore';
        $this->tpl_subno    = 'log';
        $this->tpl_subtitle = 'ログ管理';
    }

    /**
     * Page のプロセス.
     *
     * @return void
     */
    function process() {

        // ログインチェック
        SC_Utils::sfIsSuccess(new SC_Session());

        $arrModuleData = $this->getModuleData();
        $log = '';
        if (count($arrModuleData)) {
            foreach($arrModuleData as $module) {
                $name = $module['module_name'];
                $update_date = SC_Utils_Ex::sfDispDBDate($module['update_date']);

                $log .= sprintf("[%s] %s モジュール が更新されました。\n", $update_date, $name);
            }
        }

        $this->log = $log;

        // ページ出力
        $objView = new SC_AdminView();
        $objView->assignObj($this);
        $objView->display(MAIN_FRAME);
    }

    /**
     * デストラクタ.
     *
     * @return void
     */
    function destroy() {
        parent::destroy();
    }

    function getModuleData() {
        $objQuery = new SC_Query;
        $objQuery->setOrder('update_date desc');
        $arrRet = $objQuery->select('*', 'dtb_module');
        return empty($arrRet) ? array() : $arrRet;
    }
}
?>
