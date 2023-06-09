/**
 * @license Copyright (c) 2003-2020, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
    // Define changes to default configuration here.
    // For complete reference see:
    // https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_config.html

    // The toolbar groups arrangement, optimized for two toolbar rows.
    config.toolbarGroups = [
        { name: 'clipboard',   groups: ['undo' ] },
        { name: 'editing',     groups: [ 'find', 'selection'] },
        { name: 'links' },
        { name: 'insert' },
        { name: 'forms' },
        { name: 'tools' },
        { name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
        { name: 'others' },
        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        { name: 'paragraph',   groups: [ 'list', 'blocks', 'align' ] },
        { name: 'styles' },
        { name: 'colors' },
    ];

    // Remove some buttons provided by the standard plugins, which are
    // not needed in the Standard(s) toolbar.
    config.removeButtons = 'Underline,Subscript,Superscript,Cut,Copy,Paste,PasteText,PasteWord,PasteFromWord,Anchor,HorizontalRule,SpecialChar,Strike,Styles';

    // Set the most common block elements.
    config.format_tags = 'p;h2;h3;h4;h5;h6';
    config.autoParagraph = false;

    config.extraPlugins = 'image2';

    config.filebrowserBrowseUrl = false;
    // config.filebrowserUploadUrl = '/admin/articles-news/image_upload?type=Images&_token=' + $('meta[name=csrf-token]').attr("content");
    config.filebrowserUploadMethod = 'form';


    // Simplify the dialog windows.
    config.removeDialogTabs = 'image:advanced;link:advanced';

    config.extraPlugins = 'embed';

    config.embed_provider = '//ckeditor.iframe.ly/api/oembed?url={url}&callback={callback}';
};
