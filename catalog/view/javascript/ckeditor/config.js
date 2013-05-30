/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license

http://docs.cksource.com/CKEditor_3.x/Developers_Guide/Styles
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	//config.language = 'zh-cn';
	// config.uiColor = '#AADC6E';
	/*
	config.filebrowserBrowseUrl = '?route=common/filemanager';
	config.filebrowserImageBrowseUrl = '?route=common/filemanager';
	config.filebrowserFlashBrowseUrl = '?route=common/filemanager';
	config.filebrowserUploadUrl = '?route=common/filemanager';
	config.filebrowserImageUploadUrl = '?route=common/filemanager';
	config.filebrowserFlashUploadUrl = '?route=common/filemanager';		
	*/
	
	config.filebrowserWindowWidth = '800';
	config.filebrowserWindowHeight = '500';

	config.resize_enabled = false;
	
	config.htmlEncodeOutput = false;
	config.entities = false;
	
	config.toolbar = 'Custom';
	
	config.skin='v2';
	
	//自动拼写检测去掉
	config.disableNativeSpellChecker = false ;       
	config.scayt_autoStartup = false;
	
   //自定义风格
	config.toolbar_Custom = [
		['Source'],
		['Maximize','Preview'],
		['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
		['NumberedList','BulletedList','-','Outdent','Indent'],
		['JustifyLeft','JustifyCenter','JustifyRight','JustifyFull'],
		['SpecialChar','Format'],
		'/',
		['Undo','Redo'],
		['Font','FontSize'],
		['TextColor','BGColor'],
		['Link','Unlink','Anchor'],
		['Image','Table','HorizontalRule']
	];
	
	//所有栏目
	config.toolbar_Full = [
		['Source','-','Save','NewPage','Preview','-','Templates'],
		['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
		['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
		['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
		'/',
		['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
		['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
		['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
		['Link','Unlink','Anchor'],
		['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
		'/',
		['Styles','Format','Font','FontSize'],
		['TextColor','BGColor'],
		['Maximize', 'ShowBlocks','-','About']
	];

    
	config.font_names='宋体/宋体;黑体/黑体;仿宋/仿宋_GB2312;楷体/楷体_GB2312;隶书/隶书;幼圆/幼圆;微软雅黑/微软雅黑;Georgia/Georgia;Times New Roman/Times New Roman;Impact/Impact;Courier new/Courier new;Arial/Arial;verdana/verdana;Tahoma/Tahoma';
    

};
