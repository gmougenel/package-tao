define([
    'taoQtiItem/qtiItem/core/Element', 
    'lodash', 
    'taoQtiItem/qtiItem/helper/rendererConfig',
    'taoQtiItem/qtiItem/helper/util'
], function(Element, _, rendererConfig, util){

    var QtiObject = Element.extend({
        qtiClass : 'object',
        getMediaType : function(){
            var type = 'undefined';
            var mimetype = this.attr('type');
            if(mimetype){
                if(mimetype.indexOf('video') === 0){
                    type = 'video';
                }else if(mimetype.indexOf('audio') === 0){
                    type = 'audio';
                }else if(mimetype.indexOf('image') === 0){
                    type = 'image';
                }else{
                    type = 'object';
                }
            }
            return type;
        },
        render : function(){

            var args = rendererConfig.getOptionsFromArguments(arguments),
                renderer = args.renderer || this.getRenderer(),
                defaultData = {},
                baseUrl = renderer.getOption('baseUrl') || '',
                src = this.attr('data') || '';

            switch(this.getMediaType()){
                case 'video':
                    defaultData.video = true;
                    break;
                case 'audio':
                    defaultData.audio = true;
                    break;
                case 'image':
                default:
                    defaultData.object = true;
            }
            
            defaultData.attributes = {data : util.fullpath(src, baseUrl)};
            defaultData.body = this._alt;
            
            return this._super(_.merge(defaultData, args.data), args.placeholder, args.subclass, renderer);
        },
        isEmpty : function(){
            return (!this.attr('data'));
        }
    });

    return QtiObject;
});
