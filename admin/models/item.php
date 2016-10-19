<?php

defined('_JEXEC') or exit();

class Dmnd_seoModelItem extends JModelAdmin {

	public function getForm($data = array(), $loadData = true) {

		$form = $this->loadForm(
			'com_dmnd_seo.item',
			'item',
			array(
				'control' => 'jform',
				'load_data' => $loadData
				)
			);

		if (empty($form))
			return false;
		else
			return $form;
	}

	public function getTable($type = 'Item', $prefix = 'Dmnd_seoTable', $config = array()) {
		return JTable::getInstance($type, $prefix, $config);
	}

	protected function prepareTable($table) {

		$jinput = JFactory::getApplication()->input;

		$table->check();
		$table->store();
	}

	protected function loadFormData() {
		$data = $this->getItem();

		return $data;
	}

	public function getItem($pk = null) {
		if ($item = parent::getItem($pk)) {

			return $item;
		}

		return false;
	}

	public function delete (&$pks) {

		parent::delete($pks);
  	}

	public function generatemap()
	{
        $freq = "monthly";
        $priority = "0.7";
        $modified_at = date('Y-m-d\Th:i:s\Z');
        $root = str_replace("/administrator", "", JURI::base());
        $location = JPATH_SITE . "/sitemap.xml";

        unlink($location);
        $this->_db->setQuery("delete from #__dmnd_sitemap");
        $this->_db->query();

        $xml_string = '<?xml version=\'1.0\' encoding=\'UTF-8\'?>
        <urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        $file = fopen($location, "a");
        fwrite($file, $xml_string);

        $query  = "SELECT * from #__menu 
            where (menutype = 'sidebarrmenu' or menutype = 'mainmenu' or menutype = 'bottommenu1' or menutype = 'bottommenu2' or
            		menutype = 'excursionmenu' or menutype = 'hiddenmenu' or menutype = 'hidden-menu' or menutype = 'lang') and
					id not in (207, 208, 209, 101, 288, 377, 254) and
					`type` <> 'alias' and `type` <> 'url' and `type` <> 'separator' and
					published = 1
					";
      
        $this->_db->setQuery($query);
        $r = $this->_db->loadObjectList();

        foreach ($r as $key => $menu) {

            $url = $root . $menu->path;
            $url=htmlspecialchars($url);
            
            $xml_string = "
            <url>
               <loc>".$url."</loc>
               <lastmod>$modified_at</lastmod>
               <changefreq>".$freq."</changefreq>
               <priority>".$priority."</priority>
            </url>";

            fwrite($file, $xml_string);

            $this->_db->setQuery("insert into #__dmnd_sitemap (url, lastmod, changefreq, priority) values ('$url', '$modified_at', '$freq', '$priority')");
            $this->_db->query();

            if (strpos($menu->link, "option=com_content&view=category")) {
            	$catid = substr($menu->link, strpos($menu->link, "&id=")+4);

		        $query  = "SELECT a.* from #__content as a
		        				where a.catid = $catid and a.state = 1";
		        $this->_db->setQuery($query);
		        $articles = $this->_db->loadObjectList();

		        foreach ($articles as $article) {

		        	$this->_db->setQuery("select count(id) from #__menu where link = concat('index.php?option=com_content&view=article&id=', $article->id)");
		        	$is_article_already_in_menu = $this->_db->loadResult();

		        	if (!$is_article_already_in_menu) {
			        	$innerurl = $url .'/'. $article->id .'-'. $article->alias;

			            $xml_string = "
			            <url>
			               <loc>".$innerurl."</loc>
			               <lastmod>$modified_at</lastmod>
			               <changefreq>".$freq."</changefreq>
			               <priority>".$priority."</priority>
			            </url>";

			            fwrite($file, $xml_string);

			            $this->_db->setQuery("insert into #__dmnd_sitemap (url, lastmod, changefreq, priority) values ('$innerurl', '$modified_at', '$freq', '$priority')");
			            $this->_db->query();		        		
		        	}
		        }
            }

            if (strpos($menu->link, "option=com_content&view=categories")) {
            	$catid = substr($menu->link, strpos($menu->link, "&id=")+4);

		        $query  = "SELECT * from #__categories where extension = 'com_content' and parent_id = $catid and published = 1";
		        $this->_db->setQuery($query);
		        $categories = $this->_db->loadObjectList();

		        foreach ($categories as $category) {

		        	$this->_db->setQuery("select count(*) from #__menu where link like '%option=com_content&view=category&id=$category->id%'");
		        	$is = $this->_db->loadResult();

		        	if (!$is) {
			        	$innerurl = $url .'/'. $category->id .'-'. $category->alias;

			            $xml_string = "
			            <url>
			               <loc>".$innerurl."</loc>
			               <lastmod>$modified_at</lastmod>
			               <changefreq>".$freq."</changefreq>
			               <priority>".$priority."</priority>
			            </url>";

			            fwrite($file, $xml_string);

			            $this->_db->setQuery("insert into #__dmnd_sitemap (url, lastmod, changefreq, priority) values ('$innerurl', '$modified_at', '$freq', '$priority')");
			            $this->_db->query();

				        $query  = "SELECT * from #__content where catid = $category->id and state = 1 ";
				        $this->_db->setQuery($query);
				        $articles = $this->_db->loadObjectList();

				        foreach ($articles as $article) {

				        	$innerurl2 = $innerurl .'/'. $article->id .'-'. $article->alias;

				            $xml_string = "
				            <url>
				               <loc>".$innerurl2."</loc>
				               <lastmod>$modified_at</lastmod>
				               <changefreq>".$freq."</changefreq>
				               <priority>".$priority."</priority>
				            </url>";

				            fwrite($file, $xml_string);

				            $this->_db->setQuery("insert into #__dmnd_sitemap (url, lastmod, changefreq, priority) values ('$innerurl2', '$modified_at', '$freq', '$priority')");
				            $this->_db->query();
				        } 
		        	}


		        }
            }


            if (strpos($menu->link, "option=com_dmnd_hotels&view=cities")) {

		        $query  = "SELECT * from #__dmnd_city";
		        $this->_db->setQuery($query);
		        $cities = $this->_db->loadObjectList();

		        foreach ($cities as $city) {

		        	$innerurl = $url .'/'. $city->alias;

		            $xml_string = "
		            <url>
		               <loc>".$innerurl."</loc>
		               <lastmod>$modified_at</lastmod>
		               <changefreq>".$freq."</changefreq>
		               <priority>".$priority."</priority>
		            </url>";

		            fwrite($file, $xml_string);

		            $this->_db->setQuery("insert into #__dmnd_sitemap (url, lastmod, changefreq, priority) values ('$innerurl', '$modified_at', '$freq', '$priority')");
		            $this->_db->query();

			        $query  = "SELECT * from #__dmnd_hotel where id_city = $city->id and published = 1";
			        $this->_db->setQuery($query);
			        $hotels = $this->_db->loadObjectList();

			        foreach ($hotels as $hotel) {

			        	$innerurl2 = $innerurl .'/'. $hotel->alias;

			            $xml_string = "
			            <url>
			               <loc>".$innerurl2."</loc>
			               <lastmod>$modified_at</lastmod>
			               <changefreq>".$freq."</changefreq>
			               <priority>".$priority."</priority>
			            </url>";

			            fwrite($file, $xml_string);

			            $this->_db->setQuery("insert into #__dmnd_sitemap (url, lastmod, changefreq, priority) values ('$innerurl2', '$modified_at', '$freq', '$priority')");
			            $this->_db->query();
			        }
		        }
            }


            if ($menu->link == "index.php?option=com_infire&view=excursion") {

		        $query  = "SELECT * from #__infire_items where visible = 1 and published = 1";
		        $this->_db->setQuery($query);
		        $excursions = $this->_db->loadObjectList();

		        foreach ($excursions as $excursion) {

		        	$innerurl = $url .'/'. $excursion->alias;

		            $xml_string = "
		            <url>
		               <loc>".$innerurl."</loc>
		               <lastmod>$modified_at</lastmod>
		               <changefreq>".$freq."</changefreq>
		               <priority>".$priority."</priority>
		            </url>";

		            fwrite($file, $xml_string);

		            $innerurl = addslashes($innerurl);

		            $this->_db->setQuery("insert into #__dmnd_sitemap (url, lastmod, changefreq, priority) values ('$innerurl', '$modified_at', '$freq', '$priority')");
		            $this->_db->query();
		        }
            }


            if ($menu->link == "index.php?option=com_dmnd_sight&view=items") {

		        $query  = "SELECT * from #__dmnd_sight where published = 1";
		        $this->_db->setQuery($query);
		        $sights = $this->_db->loadObjectList();

		        foreach ($sights as $sight) {

		        	$innerurl = $url .'/'. $sight->alias;

		            $xml_string = "
		            <url>
		               <loc>".$innerurl."</loc>
		               <lastmod>$modified_at</lastmod>
		               <changefreq>".$freq."</changefreq>
		               <priority>".$priority."</priority>
		            </url>";

		            fwrite($file, $xml_string);

		            $innerurl = addslashes($innerurl);

		            $this->_db->setQuery("insert into #__dmnd_sitemap (url, lastmod, changefreq, priority) values ('$innerurl', '$modified_at', '$freq', '$priority')");
		            $this->_db->query();
		        }
            }


            if ($menu->link == "index.php?option=com_dmnd_spnim&view=items") {

		        $query  = "SELECT * from #__dmnd_spnim";
		        $this->_db->setQuery($query);
		        $spnims = $this->_db->loadObjectList();

		        foreach ($spnims as $spnim) {

		        	$innerurl = $url .'/'. $spnim->alias;

		            $xml_string = "
		            <url>
		               <loc>".$innerurl."</loc>
		               <lastmod>$modified_at</lastmod>
		               <changefreq>".$freq."</changefreq>
		               <priority>".$priority."</priority>
		            </url>";

		            fwrite($file, $xml_string);

		            $innerurl = addslashes($innerurl);

		            $this->_db->setQuery("insert into #__dmnd_sitemap (url, lastmod, changefreq, priority) values ('$innerurl', '$modified_at', '$freq', '$priority')");
		            $this->_db->query();
		        }
            }

        }
        
        $xml_string = "
        </urlset>";

        fwrite($file, $xml_string);     

        fclose($fn);

		return true;
	}

	public function savemap(&$ordering)
	{
		// $table         = $this->getTable();
		// $pks           = (array) $pks;

		// JPluginHelper::importPlugin($this->events_map['save']);

		// // Access checks.
		// foreach ($ordering as $i => $val)
		// {
		// 	if ($table->load($i))
		// 	{

		// 		// Skip changing of same state
		// 		if ($table->ordering == $val)
		// 		{
		// 			unset($ordering[$i]);
		// 			continue;
		// 		}

		// 		$table->ordering = (int) $val;

		// 		// Allow an exception to be thrown.
		// 		try
		// 		{
		// 			if (!$table->check())
		// 			{
		// 				$this->setError($table->getError());

		// 				return false;
		// 			}


		// 			// Store the table.
		// 			if (!$table->store())
		// 			{
		// 				$this->setError($table->getError());

		// 				return false;
		// 			}

		// 		}
		// 		catch (Exception $e)
		// 		{
		// 			$this->setError($e->getMessage());

		// 			return false;
		// 		}
		// 	}
		// }

		return true;
	}

}