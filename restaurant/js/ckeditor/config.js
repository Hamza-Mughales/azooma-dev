/*
Copyright (c) 2003-2009, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
    config.toolbar = 'MyToolbar';

    config.toolbar_MyToolbar =
    [
        { name:'Style',items:['Format','FontSize','Source','Bold','Italic','Underline','NumberedList','BulletedList','Blockquote','Link','Unlink','SpellChecker','TextColor','BGColor','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock']},
        { name:'insert',items:['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','RemoveFormat' ]}
    ];
    config.autoParagraph = false;
    config.enterMode = CKEDITOR.ENTER_BR;
};