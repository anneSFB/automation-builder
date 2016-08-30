/*! Rappid v1.7.2 - HTML5 Diagramming Framework - TRIAL VERSION

Copyright (c) 2015 client IO

 2016-07-06 


This Source Code Form is subject to the terms of the Rappid Trial License
, v. 2.0. If a copy of the Rappid License was not distributed with this
file, You can obtain one at http://jointjs.com/license/rappid_v2.txt
 or from the Rappid archive as was distributed by client IO. See the LICENSE file.*/
var Stencil = {};
Stencil.groups = {};
Stencil.shapes = {};

var _dom_url = 'http://burganic.com/projects/workflow/yii/';


joint.shapes.basic.Actions = joint.shapes.basic.Generic.extend({
    markup: '<g class="rotatable"><g class="scalable"><rect/></g><title class="action_tip"/><image class="action_img"/><image class="action_exclam"/><text class="label1" y="2.2em"/><text class="label2" y="3.6em"/></g>',
    defaults: joint.util.deepSupplement({
        type: 'basic.Actions',
        size: { width: 60, height: 60 },
        attrs: {
            'rect': { fill: 'transparent', stroke: 'transparent', width: 60, height: 60 },
            '.label1': { 'font-size': 11, text: '', 'ref-x': .5, 'ref-y': .9,  'x-alignment':'middle', 'y-alignment':'middle', ref: 'rect', fill: '#20395e', 'databasetype':'action', 'databaseid':'' },
            '.label2': { 'font-size': 10, text: '', 'ref-x': .5, 'ref-y': .9,  'x-alignment':'middle', 'y-alignment':'middle', ref: 'rect', fill: 'gray', 'databaseid':'' },
            '.action_img': { ref: 'rect', width: 60, height: 60 },
            '.action_exclam': { ref: 'rect', width: 16, height: 16, 'xlink:href': _dom_url+'plugins/rappid/img/error_icon.png' }
        }
    }, joint.shapes.basic.Generic.prototype.defaults)
});

joint.shapes.basic.Triggers = joint.shapes.basic.Generic.extend({
    markup: '<g class="rotatable"><g class="scalable"><rect/></g><title class="trigger_tip"/><image class="trigger_img"/><image class="trigger_exclam" x="-.3em" y="-.3em"/><text class="label1" y="2.2em"/><text class="label2" y="3.6em"/></g>',
    defaults: joint.util.deepSupplement({
        type: 'basic.Triggers',
        size: { width: 60, height: 60 },
        attrs: {
            'rect': { fill: 'transparent', stroke: 'transparent', width: 60, height: 60 },
            '.label1': { 'font-size': 11, text: '', 'ref-x': .5, 'ref-y': .9,  'x-alignment':'middle', 'y-alignment':'middle', ref: 'rect', fill: '#20395e', 'databasetype':'trigger', 'databaseid':'' },
            '.label2': { 'font-size': 10, text: '', 'ref-x': .5, 'ref-y': .9,  'x-alignment':'middle', 'y-alignment':'middle', ref: 'rect', fill: 'gray', 'databaseid':'' },
            '.trigger_img': { ref: 'rect', width: 60, height: 60 },
			'.trigger_exclam': { ref: 'rect', width: 16, height: 16, 'xlink:href': _dom_url+'plugins/rappid/img/error_icon.png' }
        }
    }, joint.shapes.basic.Generic.prototype.defaults)
});

joint.shapes.basic.AddDelay = joint.shapes.basic.Generic.extend({
    markup: '<g class="rotatable"><g class="scalable"><rect/></g><title class="delay_tip"/><image class="delay_img"/><image class="delay_exclam" x="-.1em"/><text  y="-.8em"/></g>',
    defaults: joint.util.deepSupplement({
        type: 'basic.AddDelay',
        size: { width: 30, height: 30 },
        attrs: {
            'rect': { fill: 'transparent', stroke: 'transparent', width: 30, height: 30 },
            'text': { 'font-size': 9, text: '', 'ref-x': .5, 'ref-y': .22,  'x-alignment':'middle', 'y-alignment':'middle', ref: 'rect', fill: '#20395e', 'databaseid':'' },
            '.delay_img': { ref: 'rect', width: 30, height: 30 },
			'.delay_exclam': { ref: 'rect', width: 12, height: 12, 'xlink:href': _dom_url+'plugins/rappid/img/error_icon.png' }
        }
    }, joint.shapes.basic.Generic.prototype.defaults)
});

function createTriggerAction(url, shapename, labelname, databaseid=null){ 
		
	if(labelname=='Add Delay'){
		var shape_trigger = new joint.shapes.basic.AddDelay({
			attrs: {
				'.delay_img': {'xlink:href': url },
				text: { text: labelname }
			}
		});
	}else if(shapename=='List of Actions'){
		var shape_trigger = new joint.shapes.basic.Actions({
			attrs: {
				'.action_img': {'xlink:href': url },
				'.label1': { text: labelname, 'databaseid':databaseid }
			}
		});
	}else{
		var shape_trigger = new joint.shapes.basic.Triggers({
			attrs: {
				'.trigger_img': {'xlink:href': url },
				'.label1': { text: labelname, 'databaseid':databaseid }
			}
		});
	}
	
	Stencil.shapes[shapename].push(shape_trigger);		
}
 


var triggers_arr = [];
var actions_arr = [];
var t_events_arr = [];
var a_events_arr = [];


$.ajaxSetup({async: false});
$.post(_dom_url+'index.php?r=automation/gettriggeractions',{},function(res){
	var actions = res.actions;
	var triggers = res.triggers;
	actions_arr = $.map(actions, function(el) { return el });
	triggers_arr = $.map(triggers, function(el) { return el });
});

for(i=0; i<actions_arr.length; i++){
	var a_id = actions_arr[i]['a_id'];		
	var a_name = actions_arr[i]['a_name'];		
	Stencil.groups[a_name] = { index: i+1, label: a_name };
	Stencil.shapes[a_name] = [];
	
	$.ajaxSetup({async: false});
	$.post(_dom_url+'index.php?r=automation/getactioneventsbyid',{id:a_id},function(res){
		var a_events = res.action_events;
		a_events_arr = $.map(a_events, function(el) { return el });
		
		for(j=0; j<a_events_arr.length; j++){		
			var ae_name = a_events_arr[j]['ae_name'];
			var ae_img = a_events_arr[j]['ae_img'];
			var ae_id = a_events_arr[j]['ae_id'];
			createTriggerAction(ae_img,a_name,ae_name,ae_id);
		}
	});
	
	
}

for(i=0; i<triggers_arr.length; i++){
	var t_id = triggers_arr[i]['t_id'];		
	var t_name = triggers_arr[i]['t_name'];		
	Stencil.groups[t_name] = { index: i+1, label: t_name };
	Stencil.shapes[t_name] = [];
	
	$.ajaxSetup({async: false});
	$.post(_dom_url+'index.php?r=automation/gettriggereventsbyid',{id:t_id},function(res){
		var t_events = res.trigger_events;
		t_events_arr = $.map(t_events, function(el) { return el });
		
		for(k=0; k<t_events_arr.length; k++){
			var te_name = t_events_arr[k]['te_name'];
			var te_img = t_events_arr[k]['te_img'];
			var te_id = t_events_arr[k]['te_id'];
			createTriggerAction(te_img,t_name,te_name,te_id);
		}
	});
	
	
}

Stencil.groups['projects'] = { index: 4, label: 'Saved Projects' };
Stencil.shapes['projects'] = [];

