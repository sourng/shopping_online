/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
config.skin = 'v2';
    config.startupFocus = false;
    config.filebrowserBrowseUrl = '/admin/content/filemanager.aspx?path=Userfiles/File&editor=FCK';
    config.filebrowserImageBrowseUrl = '/admin/content/filemanager.aspx?type=Image&path=Userfiles/Image&editor=FCK';
    config.toolbar_Full =
    [
        ['Source', '-', 'Preview', '-'],
        ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Print', 'SpellChecker'], //, 'Scayt' 
        ['Undo', 'Redo', '-', 'Find', 'Replace', '-', 'SelectAll', 'RemoveFormat'],
        '/',
        ['Bold', 'Italic', 'Underline', 'Strike', '-', 'Subscript', 'Superscript'],
        ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', 'Blockquote'],
        ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
        ['Link', 'Unlink', 'Anchor'],
        ['Image', 'Flash', 'Table', 'HorizontalRule', 'SpecialChar'],
        '/',
        ['Styles', 'Format', 'Templates'],
        ['Maximize', 'ShowBlocks']
    ];
};
