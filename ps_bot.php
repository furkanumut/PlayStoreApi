<?php 
/**
 * Class 		Play Store Api
 * @category		PHP Data Bot
 * @author		Furkan Umut Ceylan
 * @license 		https://www.gnu.org/licenses/gpl.txt  GPL License 3
 * @mail 		facfur3@gmail.com
 * @date 		08.12.2018
 */

class PlayStoreApi{
	
	public $lang="tr";
	private $link="https://play.google.com/store/apps/";

	function free_app($start=1,$total=100) {
		$start=$start-1;
		$url=$this->link."collection/topselling_free?start=$start&num=$total&hl=".$this->lang;
		$ziyaret=self::Curl($url);

		return $this->filitre($ziyaret);
	}

	function newfree_app($start=1,$total=100) {
		$start=$start-1;
		$url=$this->link."collection/topselling_new_free?start=$start&num=$total&hl=".$this->lang;
		$ziyaret=self::Curl($url);

		return $this->filitre($ziyaret);
	}

	function free_game($start=1,$total=100) {
		$start=$start-1;
		$url=$this->link."collection/topselling_free_GAME?start=$start&num=$total&hl=".$this->lang;
		$ziyaret=self::Curl($url);

		return $this->filitre($ziyaret);
	}

	function gross($start=1,$total=100) {
		$start=$start-1;
		$url=$this->link."collection/topgrossing?start=$start&num=$total&hl=".$this->lang;
		$ziyaret=self::Curl($url);

		return $this->filitre($ziyaret);
	}

	function trend($start=1,$total=100) {
		$start=$start-1;
		$url=$this->link."collection/movers_shakers?start=$start&num=$total&hl=".$this->lang;
		$ziyaret=self::Curl($url);

		return $this->filitre($ziyaret);
	}

	function listcategory(){
		$url=$this->link."category/GAME";
		$ziyaret=self::Curl($url);
		
		return $this->filitre($ziyaret, "category");
	}
	
    function category($category,$start=1,$total=100) {
		$start=$start-1;
		$url=$this->link."category/$category/collection/topselling_free?start=$start&num=$total&hl=".$this->lang;
		$ziyaret=self::Curl($url);
		return $this->filitre($ziyaret);
	}
	
	function search($search) {
		$url="https://play.google.com/store/search?q=".str_replace(" ","%20",$search)."&c=apps&hl=".$this->lang;
		$ziyaret=self::Curl($url);

		return $this->filitre($ziyaret);
	}
	
	function detail($package_name) {
		$url=$this->link."details?id=$package_name&hl=".$this->lang;
		$ziyaret=self::Curl($url);
		return $this->filitre($ziyaret,"detail");
	}

	private function filitre($sayfa,$tur="app"){
		
		if($tur=="app"){
		    $img='@data-cover-small="(.*?)"@si';
			$package_name='@<a class="title" href="/store/apps/details\?id=(.*?)" title="(.*?)" aria-hidden="true" tabindex="-1">@si';
			$developer='@<a class="subtitle" href="/store/apps/(.*?)" title="(.*?)">@si';
			$stars='@aria-label="Beş yıldız üzerinden (.*?) yıldız aldı"@si';
			preg_match_all($img,$sayfa,$img);
			preg_match_all($package_name,$sayfa,$package_name);
			preg_match_all($developer,$sayfa,$developer);
			preg_match_all($stars,$sayfa,$stars);
			return array("img"=>$img['1'],"package"=>$package_name['1'],"name"=>$package_name['2'],"developer"=>$developer['2'],"stars"=>$stars[1]);
		} 
		
		elseif ($tur=="category"){
			$category='@<a class="child-submenu-link" href="(.*?)" title="(.*?)"@si';
			preg_match_all($category,$sayfa,$category);
			foreach($category[1] as $key=>$name){
				if(strpos($category[1][$key],"GAME")){
					$return['game'][]=array("name"=>$category['2'][$key], "link"=>$category['1'][$key]);
				}
				elseif(strpos($category[1][$key],"FAMILY")){
					$return['family'][]=array("name"=>$category['2'][$key], "link"=>$category['1'][$key]);
				}
				else{
					$return['apps'][]=array("name"=>$category['2'][$key], "link"=>$category['1'][$key]);
				}
			}
			return $return;
		}
		elseif($tur=="detail"){
		    $details['icon']='@div class="dQrBL"><img src="(.*?)"@si';
		    $details['name']='@itemprop="name"><span >(.*?)</span></@si';
		    $details['developer']='@class="hrTbp R8zArc">(.*?)</a></span><span class="@si';
		    $details['category']='@<a itemprop="genre" href="https://play.google.com/store/apps/category/(.*?)"  class="hrTbp R8zArc">(.*?)</a></span></div>@si';
		    $details['pegi']='@class="T75of E1GfKc" aria-hidden="true" alt="(.*?)"@si';
		    $details['description']='@<content><div jsname="sngebd">(.*?)</div></content>@si';
		    $details['start']='@<div class="BHMmbe" aria-label="Beş üzerinden (.*?) yıldız aldı">(.*?),(.*?)</div>@si';
		    $details['screenshot']='@data-screenshot-item-index="(.*?)"><img src="(.*?)"@si';
		    $details['more']='@<div class="BgcNfc">(.*?)</div><span class="htlgb"><div><span class="htlgb">(.*?)</span></div>@si';
		    $details['date']='@Güncellendi</div><span class="htlgb"><div><span class="htlgb">(.*?)</span></div>@si';
		    foreach($details as $key=>$value){
		        preg_match_all($value,$sayfa,$details[$key]);
		        array_splice($details[$key],0,1);
		        if($key!="more"&&$key!="screenshot"){
		            foreach($details[$key] as $val){
		                $details[$key]=$val[0];
		            }
		        }
		        else{
		            $details[$key]=$details[$key][1];
		        }
		    }
	        array_splice($details['more'],0,1);
		    return $details;
		}
		
	}

	private function Curl( $url){
		$options = array ( CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HEADER => false,
			CURLOPT_ENCODING => "",
			CURLOPT_AUTOREFERER => true,
			CURLOPT_CONNECTTIMEOUT => 30,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_SSL_VERIFYPEER => false
			);
		
		$ch = curl_init("$url");
		curl_setopt_array( $ch, $options );
		$content = curl_exec( $ch );
		$err = curl_errno( $ch );
		$errmsg = curl_error( $ch );
		$header = curl_getinfo( $ch );

		curl_close( $ch );

		$header[ 'errno' ] = $err;
		$header[ 'errmsg' ] = $errmsg;
		$header[ 'content' ] = $content;

		return str_replace( array ( "\n", "\r", "\t" ), NULL, $header[ 'content' ] );
	}

}
