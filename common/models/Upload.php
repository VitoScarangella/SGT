<?php

namespace common\models;
use Yii;
use efx\validator\PiValidator;
use efx\validator\CfValidator;
use yii\web\UploadedFile;
use yii\helpers\Url;
use yii\imagine\Image;
use yii\helpers\Json;
use yii\helpers\Html;
use yii\data\ArrayDataProvider;

class Upload extends \yii\db\ActiveRecord
{
	public $docfile;


	public static $uploaddir = "";
	public static $uploadurl = "";
	public static $thumbprefix = "thumb_";


	public function init()
	{
			parent::init();
			self::$uploaddir = Yii::$app->params['upload_path'];
			self::$uploadurl = Yii::$app->params['upload_url'];
	}


	public static function setUploadDir($dir)
	{
	 self::$uploaddir = $dir;
	}

	public static function getUploadDir()
	{
	return self::$uploaddir;
	}

    /**
     * Displays a single Operazione model.
     * @param string $attachRelativePath
     * @param string $attachName
     * @param string $attachAbsolutePath
     * @return string
     */
	public static function  divImg($attachRelativePath, $attachName, $attachAbsolutePath)
	{
	//<div class="file-preview-frame" id="preview-1456578684695-0" data-fileindex="0">

	if (Tool::endsWith($attachName,".pdf"))
	{
		return $div = '
		 <div class="file-preview-frame" id="preview-1456578684695-0" data-fileindex="0">
		 <iframe style="width:400px; height:400px" src="'.$attachRelativePath . "/" . $attachName.'"></iframe>
			<div class="file-thumbnail-footer">
				<div class="file-footer-caption" title="'.$attachName.'">'.$attachRelativePath.$attachName.'</div>
				<div class="file-actions">
					<div class="file-footer-buttons">
						<button type="button" onClick="deleteImg(this,\''. $attachRelativePath . "/" .$attachName.'\')" class="btn btn-xs btn-default" title="Cancella"><i class="glyphicon glyphicon-trash text-danger"></i></button>
					</div>
				</div>
			</div>
			</div>
			';

	}
  else
	return $div = '
	 <div class="file-preview-frame" id="preview-1456578684695-0" data-fileindex="0">
		' . Html::img($attachRelativePath . "/" . $attachName, ['style'=>'max-width:250px;max-height:250px;', 'class'=>'file-preview-image', 'alt'=>' ', 'title'=>' ']) . '
		<div class="file-thumbnail-footer">
			<div class="file-footer-caption" title="'.$attachName.'">'.$attachName.'</div>
			<div class="file-actions">
				<div class="file-footer-buttons">
					<button type="button" onClick="deleteImg(this,\''. $attachRelativePath . "/" .$attachName.'\')" class="btn btn-xs btn-default" title="Cancella"><i class="glyphicon glyphicon-trash text-danger"></i></button>
				</div>
			</div>
		</div>
		</div>
		';
	//</div>
	}

    /**
     * Displays a single Operazione model.
     * @param integer $idEntity
     * @param integer $idSubEntity
     * @return string
     */
		 /*

		 echo FileInput::widget([
		     'name' => 'attachment_49[]',
		     'options'=>[
		         'multiple'=>true
		     ],
		     'pluginOptions' => [
		         'initialPreview'=>[
		             "http://upload.wikimedia.org/wikipedia/commons/thumb/e/e1/FullMoon2010.jpg/631px-FullMoon2010.jpg",
		             "http://upload.wikimedia.org/wikipedia/commons/thumb/6/6f/Earth_Eastern_Hemisphere.jpg/600px-Earth_Eastern_Hemisphere.jpg"
		         ],
		         'initialPreviewAsData'=>true,
		         'initialCaption'=>"The Moon and the Earth",
		         'initialPreviewConfig' => [
		             ['caption' => 'Moon.jpg', 'size' => '873727'],
		             ['caption' => 'Earth.jpg', 'size' => '1287883'],
		         ],
		         'overwriteInitial'=>false,
		         'maxFileSize'=>2800
		     ]


		 */
		 //Restituisce la prima che trova
		 public static function getImg($idEntity, $idSubEntity)
     {
			 $attachRelativePath = self::getRelativePath($idEntity, $idSubEntity);
			 $attachRelativeUrl = self::getRelativeUrl($idEntity, $idSubEntity);
			 try{
				 $files=\yii\helpers\FileHelper::findFiles($attachRelativePath."/",['recursive'=>false]);
				 foreach ($files as $name)
				 {
					 $name = str_replace("\\", "/", $name);
					 $attachName = substr($name, strrpos($name, '/')+1);
					 if ( Tool::startsWith($attachName, self::$thumbprefix)) continue;
					 //$data[] = ['img' => $attachRelativeUrl . "/" . $attachName,  'description' => '', 'urlAttribute'=>self::$uploadurl ];
					 return $attachRelativeUrl . "/" . $attachName;
				 }
			 }
			 catch(yii\base\InvalidParamException $e) {}
			 return "....";
		 }

		 public static function getAllImg($idEntity, $idSubEntity)
     {
			 $img = [];
			 $attachRelativePath = self::getRelativePath($idEntity, $idSubEntity);
			 $attachRelativeUrl = self::getRelativeUrl($idEntity, $idSubEntity);
			 try{
				 $files=\yii\helpers\FileHelper::findFiles($attachRelativePath."/",['recursive'=>false]);
				 foreach ($files as $name)
				 {
					 $name = str_replace("\\", "/", $name);
					 $attachName = substr($name, strrpos($name, '/')+1);
					 Tool::log("|".$attachName."|".self::$thumbprefix."|".Tool::startsWith($attachName, self::$thumbprefix));
					 if ( Tool::startsWith($attachName, self::$thumbprefix)) continue;
					 //$data[] = ['img' => $attachRelativeUrl . "/" . $attachName,  'description' => '', 'urlAttribute'=>self::$uploadurl ];
					 $img[] = $attachRelativeUrl . "/" . $attachName;
				 }
				 return $img;
			 }
			 catch(yii\base\InvalidParamException $e) {}
				 return $img;
		 }


		 public static function gridImg($idEntity, $idSubEntity, $h="600px")
     {
			 $attachRelativePath = self::getRelativePath($idEntity, $idSubEntity);
			 $attachRelativeUrl = self::getRelativeUrl($idEntity, $idSubEntity);
			 try{
				 $files=\yii\helpers\FileHelper::findFiles($attachRelativePath."/",['recursive'=>false]);
				 foreach ($files as $name)
				 {
					 $attachName = substr($name, strrpos($name, '/') + 1);
					 if ( Tool::startsWith($attachName, self::$thumbprefix)) continue;
					 //$data[] = ['img' => $attachRelativeUrl . "/" . $attachName,  'description' => '', 'urlAttribute'=>self::$uploadurl ];
					 return " <img style='height:$h;'  src='".$attachRelativeUrl . "/" . $attachName."'> ";
				 }
			 }
			 catch(yii\base\InvalidParamException $e) {}
//height:40px;
			 return "<div style='height:$h;border:0px solid red'> </div>";
		 }

		 public static function getRelativePath($idEntity, $idSubEntity="")
     {
			self::$uploaddir = Yii::$app->params['upload_path'];

			 $attachRelativePath="";
			 if ($idSubEntity=="")
 				{
 					$attachRelativePath = self::$uploaddir . "/" . $idEntity;
 				}
  			else
 				{
 					$attachRelativePath = self::$uploaddir . "/" . $idEntity . "/" . $idSubEntity;
  			}
				return $attachRelativePath;
		 }


		 public static function getRelativeUrl($idEntity, $idSubEntity="")
     {
			 self::$uploadurl = Yii::$app->params['upload_url'];

			 $attachRelativeUrl="";
			 if ($idSubEntity=="")
 				{
 					$attachRelativeUrl = self::$uploadurl . "/" . $idEntity;
 				}
  			else
 				{
 					$attachRelativeUrl = self::$uploadurl . "/" . $idEntity . "/" . $idSubEntity;
  			}
				return $attachRelativeUrl;
		 }


		 public static function buildImgDataProvider($idEntity, $idSubEntity="")
     {

			 $data = [ ];
			 //$idEntity = \Yii::$app->user->identity->id; // 1
			 $attachRelativePath = self::getRelativePath($idEntity, $idSubEntity);
			 $attachRelativeUrl = self::getRelativeUrl($idEntity, $idSubEntity);

 			if (!file_exists(self::$uploaddir . "/" . $idEntity)) {
 					mkdir(self::$uploaddir . "/" . $idEntity, 0777, true);
 			}
 			if (!file_exists($attachRelativePath)) {
 					mkdir($attachRelativePath, 0777, true);
 			}

 			$files=\yii\helpers\FileHelper::findFiles($attachRelativePath."/",['recursive'=>false]);
 			$initialPreview = $initialPreviewConfig = $errorkeys = $p4 = [];
 			$out="";
     	//if (!isset($files[0]))  return "";
 				$i=0;
       foreach ($files as $name) {
 					$name = str_replace("\\","",$name);
 					$attachAbsolutePath = str_replace("\\","/",\Yii::$app->basePath) . "/web/" . $name;

 					$attachName = substr($name, strrpos($name, '/') + 1);
 					if ( Tool::startsWith($attachName, self::$thumbprefix)) continue;

					$data[] = ['img' => $attachRelativeUrl . "/" . $attachName,  'description' => '', 'urlAttribute'=>self::$uploadurl ];
 					$out .= self::divImg($attachRelativePath, $attachName, $attachAbsolutePath);
 					}

					$dataProviderPhoto = new ArrayDataProvider([
	            'allModels' => $data,
	            'pagination' => [
	                'pageSize' => 10,
	            ],

	        ]);

 			return array(self::$uploadurl,  $dataProviderPhoto);

		 }


    public static function attachList($idEntity, $idSubEntity="")
    {
			//$idEntity = \Yii::$app->user->identity->id; // 1
			Tool::log($idSubEntity);
			if ($idSubEntity=="")
				{
					Tool::log("a");
					$attachRelativePath = self::$uploaddir . "/" . $idEntity;
					$attachRelativeUrl = self::$uploadurl . "/" . $idEntity;
				}
			else
				{
					Tool::log("b");
					$attachRelativePath = self::$uploaddir . "/" . $idEntity . "/" . $idSubEntity;
					$attachRelativeUrl = self::$uploadurl . "/" . $idEntity . "/" . $idSubEntity;
				}

			if (!file_exists(self::$uploaddir . "/" . $idEntity)) {
					mkdir(self::$uploaddir . "/" . $idEntity, 0777, true);
			}
			if (!file_exists($attachRelativePath)) {
					mkdir($attachRelativePath, 0777, true);
			}

			Tool::log($attachRelativePath);

			$files=\yii\helpers\FileHelper::findFiles($attachRelativePath."/",['recursive'=>false]);
			$initialPreview = $initialPreviewConfig = $errorkeys = $p4 = [];
			$out="";
    	if (!isset($files[0]))  return "";
				$i=0;
				Tool::log("@@@@>" . $attachRelativePath);
      foreach ($files as $name) {
				Tool::log("======>" . $name);
					$name = str_replace("\\","",$name);
					$attachAbsolutePath = str_replace("\\","/",\Yii::$app->basePath) . "/web/" . $name;

					$attachName = substr($name, strrpos($name, '/') + 1);
					if ( Tool::startsWith($attachName, self::$thumbprefix)) continue;

					$out .= self::divImg($attachRelativeUrl, $attachName, $attachAbsolutePath);
					}

			return $out;
	}

	public function deleteImg($img)
	{
		$ris = unlink(Yii::$app->basePath."/web/".$img);
		$attachName = substr($img, strrpos($img, '/') + 1);
		$urlName = substr($img, 0, strrpos($img, '/')+1 );
		$ris = unlink(Yii::$app->basePath."/web/". $urlName . self::$thumbprefix . $attachName);
		return "OK";
	}

    public function upload($urlCancel="",$idEntity="",$idSubEntity="")
    {
			if ($urlCancel=="") 	$urlCancel=(isset($_REQUEST["urlCancel"])?$_REQUEST["urlCancel"]:"");
			if ($idEntity=="") 		$idEntity=(isset($_REQUEST["idEntity"])?$_REQUEST["idEntity"]:"");
			if ($idSubEntity=="") $idSubEntity=(isset($_REQUEST["idSubEntity"])?$_REQUEST["idSubEntity"]:"");


		$valid = $this->validate();
		Tool::logValidate($this);
		$attachRelativePath = self::$uploaddir;

		if (!file_exists($attachRelativePath))
				mkdir($attachRelativePath, 0777, true);

		if($idEntity!="")
			$attachRelativePath = $attachRelativePath . "/" . $idEntity;
		if (!file_exists($attachRelativePath))
				mkdir($attachRelativePath, 0777, true);

		if($idSubEntity!="")
			$attachRelativePath = $attachRelativePath . "/" . $idSubEntity;
		if (!file_exists($attachRelativePath))
				mkdir($attachRelativePath, 0777, true);

		if (!$valid) return;

			$virgola="";
			$i = 0;
			$initialPreview = $initialPreviewConfig = $errorkeys = $p4 = [];
			$esitoSalvataggio="";
			foreach ($this->docfile as $file) {
				$esito = $file->saveAs($attachRelativePath.'/' . $file->baseName . '.' . $file->extension);
				$esitoSalvataggio .= $esito?" Upload ok ":" Problema su Upload ";
				Image::thumbnail($attachRelativePath . "/" . $file->name, 40, 40)->save($attachRelativePath . "/" . self::$thumbprefix . $file->name , ['quality' => 50]);
				}

 			$files=\yii\helpers\FileHelper::findFiles($attachRelativePath."/",['recursive'=>false]);
			$out="";
    	if (isset($files[0])) {
					$i=0;
        	foreach ($files as $name) {
							$attachAbsolutePath = str_replace("\\","/",\Yii::$app->basePath) . "/web/" . $name;
							$attachName = substr($name, strrpos($name, '/') + 2);

							if ( Tool::startsWith($attachName, self::$thumbprefix)) continue;

							$i = $i + 1;
							////@@@@@@@@@@@ modificare!!!
							$url = Url::base().'/operazione/cancelattach&filename='.$attachRelativePath.'/'.$attachName.'&filenamethumb='.$attachRelativePath . "/" . self::$thumbprefix . $attachName . '&imgpath='.$attachRelativePath;
							$initialPreview[$i] = "<img src='" . Url::base() . "/" . $attachRelativePath . "/" . self::$thumbprefix . $attachName . "' class='file-preview-image'>";
							$initialPreviewConfig[$i] = ['caption' => $attachName	,  'url' => $url, 'key' => $i ];
							$errorkeys[$i] = $i;
							$p4[$i] = ['{CUSTOM_TAG_NEW}'=> ' ','{CUSTOM_TAG_INIT}'=> 'lt;span class=\'custom-css\'>CUSTOM MARKUPlt;/span>'];
							}
					}

				return Json::encode([
					'error' => $esitoSalvataggio,
					'errorkeys' => array_values($errorkeys),
					'options'=>[
              'multiple'=>true
          ],
			    'initialPreviewAsData'=>false,
					'initialPreviewShowDelete'=>true,
					'initialPreview' => $this->attachList($idEntity,$idSubEntity), //array_values($initialPreview),
					'showRemove' => true,
			    'initialCaption'=>"Allegati",
			    'overwriteInitial'=>true,
					'append' => false, // false:overwrite true:append
					'uploadAsync' => true,
			    'uploadExtraData' => [
			        'urlCancel' => 'operazione/cancelattach',
			        'idEntity' => $idEntity,
			        'idSubEntity' => $idSubEntity,
			        'idUtente' => $idEntity,  ///@@@@@@@@@@@@@@@
			    ],
					]);

    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['docfile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, pdf, doc, docx, xls, xlsx', 'maxFiles' => 4],



        ];
    }


}
