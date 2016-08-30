/*! Rappid v1.7.2 - HTML5 Diagramming Framework - TRIAL VERSION

Copyright (c) 2015 client IO

 2016-07-06 


This Source Code Form is subject to the terms of the Rappid Trial License
, v. 2.0. If a copy of the Rappid License was not distributed with this
file, You can obtain one at http://jointjs.com/license/rappid_v2.txt
 or from the Rappid archive as was distributed by client IO. See the LICENSE file.*/
var _dom_url = 'http://burganic.com/projects/workflow/yii/';

var Rappid = Backbone.Router.extend({

    routes: {
        '*path': 'home'
    },

    initialize: function(options) {        
        this.options = options || {};
    },

    home: function() {
        this.initializeEditor();
    },

    initializeEditor: function() {

        this.inspectorClosedGroups = {};
        this.initializePaper();
        this.initializeStencil();
        this.initializeSelection();
        this.initializeHaloAndInspector();
        this.initializeNavigator();
        this.initializeClipboard();
        this.initializeCommandManager();
        this.initializeToolbar();
        // Intentionally commented out. See the `initializeValidator()` method for reasons.
        // Uncomment for demo purposes.
        // this.initializeValidator();
        // Commented out by default. You need to run `node channelHub.js` in order to make
        // channels working. See the documentation to the joint.com.Channel plugin for details.
        //this.initializeChannel('ws://jointjs.com:4141');
        if (this.options.channelUrl) {
            this.initializeChannel(this.options.channelUrl);
        }
		
		//added: trigger loadproject
		var id = $('#current_id').val();
		if(id!=''){
			$('.loadproject[data-id="'+id+'"]').trigger('click');
		}
		//added end
    },

    // Create a graph, paper and wrap the paper in a PaperScroller.
    initializePaper: function() {
        
        this.graph = new joint.dia.Graph;

        this.graph.on('add', function(cell, collection, opt) {
            if (opt.stencil) {                
                this.commandManager.stopListening();                
                this.commandManager.listen();
            }
        }, this);

        this.paper = new joint.dia.Paper({
            width: 2000,
            height: 1000,
            gridSize: 20,
			snapLinks:true,
			linkPinning :false,
			multiLinks  :false,
            model: this.graph,
			linkConnectionPoint: joint.util.shapePerimeterConnectionPoint,
			defaultLink: new joint.dia.Link({
				attrs: {
					'.marker-vertices': { display : 'none' },
					'.marker-arrowheads': { display: 'none' },
					'.marker-source': { d: 'M 5 10 A 5 5, 0, 1, 0, 6 10 L 0 15 Z', transform: 'scale(0.7)', fill: '#d7dde3', stroke: '#d7dde3' }, // scale(0) fails in Firefox
					'.marker-target': { d: 'M 10 0 L 0 5 L 10 10 z', transform: 'scale(0.5)', fill: '#d7dde3', stroke: '#d7dde3' },
					'.connection': { stroke: '#d7dde3','stroke-width': 2 }
				}				
			}),
			linkView: joint.dia.LinkView.extend({
				pointermove: function (cellView, magnet) {					
					var cond = $('#current_cond').val();	
						
					if(cond=='') cond = 'd7dde3';
					var newcolor = '#'+cond;
					this.model.attr({
						'.marker-source': { stroke: newcolor, fill: newcolor }
					});
					joint.dia.LinkView.prototype.pointermove.apply(this, arguments);					
				},
				pointerup: function (cellView, magnet) {
					var cond_label = $('#current_cond_label').val();
					//console.log(cond_label);
					if(cond_label!=''){
						this.model.label(0,{
							position: .5,
							attrs: { 
								rect: { fill:'white', stroke: 'transparent', 'stroke-width': 20 }, 
								text: { text:  cond_label, 'font-size': 11 }
							}
						});		
					}
					joint.dia.LinkView.prototype.pointerup.apply(this, arguments);
					$('#current_cond_label').val('');					
					$('#current_cond').val('');
				}
			}),
			interactive: function(cellView,evt,x,y) {
				cellView = cellView.model || cellView;				
				if (cellView instanceof joint.dia.Link) {			
					// Disable the default vertex add functionality on pointerdown.
					return { vertexAdd: false };
				}				
				return true;
			},
			validateConnection: function(cellViewS, magnetS, cellViewT, magnetT, end, linkView) {
                // Prevent linking within one element.
                if (cellViewS === cellViewT) return false;
				return true;
			}
        });

        this.paperScroller = new joint.ui.PaperScroller({
            autoResizePaper: true,
            padding: 0,
            paper: this.paper
        });

        this.paperScroller.$el.appendTo('.paper-container');

        this.paperScroller.center();

        this.snapLines = new joint.ui.Snaplines({ paper: this.paper });
		
	},

    // Create and popoulate stencil.
    initializeStencil: function() {

        this.stencil = new joint.ui.Stencil({
            paper: this.paperScroller,
            width: 240,
            groups: Stencil.groups,
            dropAnimation: true
        });

        $('.stencil-container').append(this.stencil.render().el);

        this.stencil.$el.on('contextmenu', function(evt) { evt.preventDefault(); });
        $('.stencil-paper-drag').on('contextmenu', function(evt) { evt.preventDefault(); });

        var layoutOptions = {
            columnWidth: this.stencil.options.width / 2 - 10,
            columns: 2,
            rowHeight: 100,
            dy: 10,
            dx: 10
        };

        _.each(Stencil.groups, function(group, name) {            
            this.stencil.load(Stencil.shapes[name], name);
            joint.layout.GridLayout.layout(this.stencil.getGraph(name), layoutOptions);
            this.stencil.getPaper(name).fitToContent(1, 1, 10);
        }, this);

        this.stencil.on('filter', function(graph) {
            joint.layout.GridLayout.layout(graph, layoutOptions);
        });

        $('.stencil-container .btn-expand').on('click', _.bind(this.stencil.openGroups, this.stencil));
        $('.stencil-container .btn-collapse').on('click', _.bind(this.stencil.closeGroups, this.stencil));
		
		
		//start: load project list 
		var projectlisthtml = $('#projectlistcontainer').html();
		$('.stencil-container').find('.stencil').find('.content').find('.group').last().addClass('listofprojects');
		
		$('.stencil-container').find('.stencil').find('.content').find('.group').last().find('.elements').find('svg').remove();
		$('.stencil-container').find('.stencil').find('.content').find('.group').last().find('.elements').append(projectlisthtml);
		
		$('.stencil-container').find('.stencil').find('.content').find('.group[data-name="List of Actions"]').addClass('listofactions');
		$('.stencil-container').find('.stencil').find('.content').find('.group[data-name="Time Delay"]').addClass('listofactions');
		$('.listofactions').hide();
		$('.listofprojects').hide();
		//end
		
        //this.initializeStencilTooltips();
    },

    initializeStencilTooltips: function() {

        // Create tooltips for all the shapes in stencil.
        _.each(this.stencil.graphs, function(graph) {

            graph.get('cells').each(function(cell) {

                new joint.ui.Tooltip({
                    target: '.stencil [model-id="' + cell.id + '"]',
                    content: cell.get('type').split('.').join(' '),
                    left: '.stencil',
                    direction: 'left'
                });
            });
        });
    },

    initializeSelection: function() {
        
        this.selection = new Backbone.Collection;
        this.selectionView = new joint.ui.SelectionView({ paper: this.paper,  model: this.selection });

        // Initiate selecting when the user grabs the blank area of the paper while the Shift key is pressed.
        // Otherwise, initiate paper pan.
        this.paper.on('blank:pointerdown', function(evt, x, y) {

            if (_.contains(KeyboardJS.activeKeys(), 'shift')) {
                this.selectionView.startSelecting(evt, x, y);
            } else {
                this.selectionView.cancelSelection();
                this.paperScroller.startPanning(evt, x, y);
            }
        }, this);

        this.paper.on('cell:pointerdown', function(cellView, evt) {
            // Select an element if CTRL/Meta key is pressed while the element is clicked.
            if ((evt.ctrlKey || evt.metaKey) && !(cellView.model instanceof joint.dia.Link)) {
                this.selection.add(cellView.model);
                this.selectionView.createSelectionBox(cellView);
            }
        }, this);

        this.selectionView.on('selection-box:pointerdown', function(evt) {
            // Unselect an element if the CTRL/Meta key is pressed while a selected element is clicked.
            if (evt.ctrlKey || evt.metaKey) {
                var cell = this.selection.get($(evt.target).data('model'));
                this.selection.reset(this.selection.without(cell));
                this.selectionView.destroySelectionBox(this.paper.findViewByModel(cell));
            }
        }, this);

        // Disable context menu inside the paper.
        // This prevents from context menu being shown when selecting individual elements with Ctrl in OS X.
        this.paper.el.oncontextmenu = function(evt) { evt.preventDefault(); };

        KeyboardJS.on('delete, backspace', _.bind(function(evt, keys) {

            if (!$.contains(evt.target, this.paper.el)) {
                // remove selected elements from the paper only if the target is the paper
                return;
            }

            this.commandManager.initBatchCommand();
            this.selection.invoke('remove');
            this.commandManager.storeBatchCommand();
            this.selectionView.cancelSelection();

            // Prevent Backspace from navigating one page back (happens in FF).
            if (_.contains(keys, 'backspace') && !$(evt.target).is("input, textarea")) {

                evt.preventDefault();
            }

        }, this));
    },

    createInspector: function(cellView) {

        var cell = cellView.model || cellView;

        // No need to re-render inspector if the cellView didn't change.
        if (!this.inspector || this.inspector.options.cell !== cell) {

            // Is there an inspector that has not been removed yet.
            // Note that an inspector can be also removed when the underlying cell is removed.
            if (this.inspector && this.inspector.el.parentNode) {

                this.inspectorClosedGroups[this.inspector.options.cell.id] = _.map(app.inspector.$('.group.closed'), function(g) {
				return $(g).attr('data-name');
			});
                
                // Clean up the old inspector if there was one.
                this.inspector.updateCell();
                this.inspector.remove();
            }

            var inspectorDefs = InspectorDefs[cell.get('type')];

            this.inspector = new joint.ui.Inspector({
                inputs: inspectorDefs ? inspectorDefs.inputs : CommonInspectorInputs,
                groups: inspectorDefs ? inspectorDefs.groups : CommonInspectorGroups,
                cell: cell
            });

            this.initializeInspectorTooltips();
            
            this.inspector.render();
            $('.inspector-container').html(this.inspector.el);

            if (this.inspectorClosedGroups[cell.id]) {

				_.each(this.inspectorClosedGroups[cell.id], this.inspector.closeGroup, this.inspector);

            } else {
                this.inspector.$('.group:not(:first-child)').addClass('closed');
            }
        }
    },

    initializeInspectorTooltips: function() {
        
        this.inspector.on('render', function() {

            this.inspector.$('[data-tooltip]').each(function() {

                var $label = $(this);
                new joint.ui.Tooltip({
                    target: $label,
                    content: $label.data('tooltip'),
                    right: '.inspector',
                    direction: 'right'
                });
            });
            
        }, this);
    },

    initializeHaloAndInspector: function() {

        this.paper.on('cell:pointerup', function(cellView, evt) {
			var thispaper2 = this.paper;			
			
            if (cellView.model instanceof joint.dia.Link || this.selection.contains(cellView.model)) return;

            // In order to display halo link magnets on top of the freetransform div we have to create the
            // freetransform first. This is necessary for IE9+ where pointer-events don't work and we wouldn't
            // be able to access magnets hidden behind the div.
            //var freetransform = new joint.ui.FreeTransform({ cellView: cellView, allowRotation: false });
            var halo = new joint.ui.Halo({ cellView: cellView,boxContent:false });

            // As we're using the FreeTransform plugin, there is no need for an extra resize tool in Halo.
            // Therefore, remove the resize tool handle and reposition the clone tool handle to make the
            // handles nicely spread around the elements.
            halo.removeHandle('resize');
            halo.removeHandle('fork');
            halo.removeHandle('clone');
            halo.removeHandle('unlink');
            halo.removeHandle('rotate');
            halo.changeHandle('remove', { position: 'eRemove'});
            halo.changeHandle('link', { position: 'eAddport'});
			
			
			halo.on('action:link:pointerdown', function(evt,x,y) {	
				if (cellView.model instanceof joint.shapes.basic.Triggers || cellView.model instanceof joint.shapes.basic.Actions){
					var cell = cellView.model || cellView;
					
					//var position = cellView.model.get('position');
					var celltype = cell.attr('.label1/databasetype');
					var cellid = cell.attr('.label1/databaseid');
					var positionx = $('.halo.surrounding').css('left');
					var positiony = $('.halo.surrounding').css('top');
					$('.halo').hide();
					
					var $html = $('<ul class="list-conditions"><li> fetching data ...</li></ul>');
					var styles = { fontSize : "12px", position: "absolute",marginTop:"5px",marginLeft:"60px",left: positionx, top: positiony };
					$html.css(styles).appendTo(thispaper2.el);	
					
					var html2 = '';
					
					$.ajaxSetup({async: false});
					$.post(_dom_url+'index.php?r=automation/getconditions',{type:celltype,id:cellid},function(res){
						var conditions_res = res.conditions;
						var conditions = $.map(conditions_res, function(el) { return el });
						
						if(conditions.length>0){
							for(i=0; i<conditions.length; i++){
								if(celltype=='action'){
									var label = conditions[i]['aec_label'];		
									var color = conditions[i]['aec_color'];	
								}else if(celltype=='trigger'){
									var label = conditions[i]['tec_label'];		
									var color = conditions[i]['tec_color'];	
								}
								
								html2 += '<li class="list-cond '+color+'"><div style="background:#'+color+'"></div> '+label+'</li>';
							}
							
							$('.list-conditions').html(html2);
							
							$('.list-cond').on("mouseenter", function(evt){						
								var classes = $(this).attr('class');						
								var selected = classes.replace('list-cond ','');
								var selected_label = $(this).text();
								
								$('#current_cond').val(selected);
								$('#current_cond_label').val(selected_label);
								
							});

						}else{
							$('.list-conditions').remove();
						}
						
					});
					
		
				}else{
					$('#current_cond').val('');
					$('#current_cond_label').val('');
				}		
			});
			halo.on('action:link:pointerup', function(evt,x,y) {
				$('.list-conditions').remove();					
				$('.halo').show();			
			});
            
			//added custom handle for config option
            halo.addHandle({ name: 'configure', position: 'eConfigure' });
			halo.on('action:configure:pointerdown', function(evt) {
				
				var cell = cellView.model || cellView;
				
				if (cell instanceof joint.shapes.basic.AddDelay){
					
					var label = cell.attr('text/text');
					var delaynumDay = 0;
					var delaynumHr = 0;
					var delaynumMin = 0;
					
					if(label!= 'Add Delay'){						
						label = label.replace('Wait  ','');
						labelarr = label.split(' ');
						labelarr.pop();
						
						for(i=0; i<labelarr.length; i++){
							var num = labelarr[i++];
							var type = labelarr[i];
							
							if(type=='days') delaynumDay = num;
							if(type=='hrs')	delaynumHr = num;
							if(type=='mins') delaynumMin = num;
						}						
					}
					
					var content = '<label>Delay this step for:</label><input type="text" value="'+delaynumDay+'" id="delaynumDay" class="delaynum" /> Days <input type="text" value="'+delaynumHr+'" id="delaynumHr" class="delaynum" /> Hours <input type="text" value="'+delaynumMin+'" id="delaynumMin" class="delaynum" /> Minutes<br><a href="javascript:void(0)" id="delayremove"><div class="delay-x">x</div> Remove Delay</a><button id="delaybtn">Save</button><br><br><br>';
					var dialog = new joint.ui.Dialog({
						width: '300px',
						height: '200px',
						type: 'neutral',
						draggable: true,
						title: 'Modify the Delay',
						content: content
					});

					dialog.open();				
					
					$('#delayremove').on('click',function(){						
						cell.remove();
						dialog.close();	
					});
					
					$('#delaybtn').on('click',function(){
						var delaynumDay = $('#delaynumDay').val();						
						var delaynumHr = $('#delaynumHr').val();
						var delaynumMin = $('#delaynumMin').val();
						var label = 'Wait  ';
						
						if(delaynumDay!='0'){
							label += delaynumDay+' days ';
						}
						if(delaynumHr!='0'){
							label += delaynumHr+' hrs ';
						}
						if(delaynumMin!='0'){
							label += delaynumMin+' mins ';
						}						
						if(delaynumDay=='0' && delaynumHr=='0' && delaynumMin=='0'){							
							label = '';
						}	
						cell.attr('text/text', label);
						
						if(label!=''){
							cell.attr('.delay_exclam/xlink:href', _dom_url+'plugins/rappid/img/error_icon_hide.png');	
						}else{
							cell.attr('.delay_exclam/xlink:href',  _dom_url+'plugins/rappid/img/error_icon.png');	
						}
						
						dialog.close();	
					});
				}else if (cell instanceof joint.shapes.basic.Triggers){
					var cellid = cell.attr('.label1/databaseid');
					var triggerlabel = cell.attr('.label1/text');
					var confightml = '';
					
					var dialog = new joint.ui.Dialog({
						width: '500px',
						height: '600px',
						type: 'neutral',
						draggable: true,
						title: 'Trigger Configuration',
						content: '<div id="confightml"><br>Please wait while we fetch data...</div>'
					});

					dialog.open();
					
					$.post(_dom_url+'index.php?r=automation/gettriggerconfigurations',{id:cellid},function(res){
						var configdata_res = res.configdata;
						var configdata = $.map(configdata_res, function(el) { return el });						
						var confightmlopt = '';
						
						if(configdata.length>0){
							for(i=0; i<configdata.length; i++){
								var configopt = configdata[i]['t_config_option'];
								var configoptid = configdata[i]['t_config_id'];
								confightmlopt += '<option value="'+configoptid+'">'+configopt+'</option>';
							}
							confightml = 'Select '+triggerlabel+':<br><select id="configopt"><option value="">--select--</option>'+confightmlopt+'</select><br><br><button id="saveconfigbtn">Save Configuration</button>';
						}else{
							confightml = 'nothing to configure';
						}
						$('#confightml').html(confightml);
						
						$('#saveconfigbtn').on('click',function(){
							var optval = $('#configopt').val();
							var opttext = $("#configopt option:selected").text();
							cell.attr('.label2/databaseid', optval);
							cell.attr('.label2/text', opttext);
							if(optval!=''){
								cell.attr('.trigger_exclam/xlink:href', _dom_url+'plugins/rappid/img/error_icon_hide.png');								
							}else{
								cell.attr('.trigger_exclam/xlink:href', _dom_url+'plugins/rappid/img/error_icon.png');
								cell.attr('.label2/text', '');
							}					
							dialog.close();
						});
					});
				}else if (cell instanceof joint.shapes.basic.Actions){
					var cellid = cell.attr('.label1/databaseid');
					var triggerlabel = cell.attr('.label1/text');
					var confightml = '';
					
					var dialog = new joint.ui.Dialog({
						width: '500px',
						height: '600px',
						type: 'neutral',
						draggable: true,
						title: 'Action Configuration',
						content: '<div id="confightml"><br>Please wait while we fetch data...</div>'
					});

					dialog.open();
					$.post(_dom_url+'index.php?r=automation/getactionconfigurations',{id:cellid},function(res){
						var configdata_res = res.configdata;
						var configdata = $.map(configdata_res, function(el) { return el });						
						var confightmlopt = '';
						
						if(configdata.length>0){
							for(i=0; i<configdata.length; i++){
								var configopt = configdata[i]['a_config_option'];
								var configoptid = configdata[i]['a_config_id'];
								confightmlopt += '<option value="'+configoptid+'">'+configopt+'</option>';
							}
							confightml = 'Select '+triggerlabel+':<br><select id="configopt"><option value="">--select--</option>'+confightmlopt+'</select><br><br><button id="saveconfigbtn">Save Configuration</button>';
						}else{
							confightml = 'No data fetched, please close modal.';
							cell.attr('.action_exclam/xlink:href', _dom_url+'plugins/rappid/img/error_icon_hide.png');	
						}
						$('#confightml').html(confightml);
						
						$('#saveconfigbtn').on('click',function(){
							var optval = $('#configopt').val();
							var opttext = $("#configopt option:selected").text();
							cell.attr('.label2/databaseid', optval);
							cell.attr('.label2/text', opttext);
							if(optval!=''){
								cell.attr('.action_exclam/xlink:href', _dom_url+'plugins/rappid/img/error_icon_hide.png');								
							}else{
								cell.attr('.action_exclam/xlink:href', _dom_url+'plugins/rappid/img/error_icon.png');
								cell.attr('.label2/text', '');
							}					
							dialog.close();
						});
					});
				}else{
					var dialog = new joint.ui.Dialog({
						width: '500px',
						height: '600px',
						type: 'neutral',
						draggable: true,
						title: 'Configure Modal',
						content: '<div style="height:300px"><br><br><br>add contents here...</div>'
					});

					dialog.open();
				}
				
			},this);
            halo.render();

            this.initializeHaloTooltips(halo);
            this.selectionView.cancelSelection();
            this.selection.reset([cellView.model]);
            
        }, this);

    },

    initializeNavigator: function() {

        var navigator = this.navigator = new joint.ui.Navigator({
            width: 240,
            height: 115,
            paperScroller: this.paperScroller,
            zoomOptions: { max: 5, min: 0.2 }
        });

        navigator.$el.appendTo('.navigator-container');
        navigator.render();
    },

    initializeHaloTooltips: function(halo) {

        new joint.ui.Tooltip({
            className: 'tooltip small',
            target: halo.$('.remove'),
            content: 'Click to remove the object',
            direction: 'left',
            left: halo.$('.remove'),
            padding: 15
        });
        new joint.ui.Tooltip({
            className: 'tooltip small',
            target: halo.$('.link'),
            content: 'Click and drag to connect the object',
            direction: 'left',
            left: halo.$('.link'),
            padding: 15
        });
		 new joint.ui.Tooltip({
            className: 'tooltip small',
            target: halo.$('.configure'),
            content: 'Click to update configuration',
            direction: 'left',
            left: halo.$('.link'),
            padding: 15
        });
    },

    initializeClipboard: function() {

        this.clipboard = new joint.ui.Clipboard;
        
        KeyboardJS.on('ctrl + c', _.bind(function() {
            // Copy all selected elements and their associated links.
            this.clipboard.copyElements(this.selection, this.graph, { translate: { dx: 20, dy: 20 }, useLocalStorage: true });
        }, this));
        
        KeyboardJS.on('ctrl + v', _.bind(function() {

            this.selectionView.cancelSelection();

            this.clipboard.pasteCells(this.graph, { link: { z: -1 }, useLocalStorage: true });

            // Make sure pasted elements get selected immediately. This makes the UX better as
            // the user can immediately manipulate the pasted elements.
            this.clipboard.each(function(cell) {

                if (cell.get('type') === 'link') return;

                // Push to the selection not to the model from the clipboard but put the model into the graph.
                // Note that they are different models. There is no views associated with the models
                // in clipboard.
                this.selection.add(this.graph.getCell(cell.id));
		this.selectionView.createSelectionBox(cell.findView(this.paper));

            }, this);

        }, this));

        KeyboardJS.on('ctrl + x', _.bind(function() {

            var originalCells = this.clipboard.copyElements(this.selection, this.graph, { useLocalStorage: true });
            this.commandManager.initBatchCommand();
            _.invoke(originalCells, 'remove');
            this.commandManager.storeBatchCommand();
            this.selectionView.cancelSelection();
        }, this));
    },

    initializeCommandManager: function() {

        this.commandManager = new joint.dia.CommandManager({ graph: this.graph });

        KeyboardJS.on('ctrl + z', _.bind(function() {

            this.commandManager.undo();
            this.selectionView.cancelSelection();
        }, this));
        
        KeyboardJS.on('ctrl + y', _.bind(function() {

            this.commandManager.redo();
            this.selectionView.cancelSelection();
        }, this));
    },

    initializeValidator: function() {

        // This is just for demo purposes. Every application has its own validation rules or no validation
        // rules at all.
        
        this.validator = new joint.dia.Validator({ commandManager: this.commandManager });

        this.validator.validate('change:position change:size add', _.bind(function(err, command, next) {

            if (command.action === 'add' && command.batch) return next();

            var cell = command.data.attributes || this.graph.getCell(command.data.id).toJSON();
            var area = g.rect(cell.position.x, cell.position.y, cell.size.width, cell.size.height);

            if (_.find(this.graph.getElements(), function(e) {

	        var position = e.get('position');
                var size = e.get('size');
	        return (e.id !== cell.id && area.intersect(g.rect(position.x, position.y, size.width, size.height)));

            })) return next("Another cell in the way!");
        }, this));

        this.validator.on('invalid',function(message) {
            
            $('.statusbar-container').text(message).addClass('error');

            _.delay(function() {

                $('.statusbar-container').text('').removeClass('error');
                
            }, 1500);
        });
    },

    initializeToolbar: function() {
		var base_url = $('#base_url').val();
		var prev_id = 0;
        this.initializeToolbarTooltips();
		this.setGrid(20);
		$('#btn-zoom-in').on('click', _.bind(function() { this.paperScroller.zoom(0.2, { max: 5, grid: 0.2 }); }, this));
        $('#btn-zoom-out').on('click', _.bind(function() { this.paperScroller.zoom(-0.2, { min: 0.2, grid: 0.2 }); }, this));
        $('#btn-zoom-to-fit').on('click', _.bind(function() {
            this.paperScroller.zoomToFit({
                padding: 20,
                scaleGrid: 0.2,
                minScale: 0.2,
                maxScale: 5
            });
        }, this));
        $('#btn-fullscreen').on('click', _.bind(this.toggleFullscreen, this));
		$('#btn-save').on('click', _.bind(function() {
			var jsonString  = JSON.stringify(this.graph);
			var projname = $('#projname').val();

			if (projname!='') {
				$.post(_dom_url+'index.php?r=automation/saveproject',{name:projname,graphdata:jsonString},function(res){
					alert('Successfully saved!');
					window.location.href=window.location.href+'?id='+res.id;
				});
			}else{
				alert('Project name is required.');
				$('#projname').focus();
			}
			
		}, this));
		$('.loadproject').on('click', _.bind(function (evt){
			var thisgraph = this.graph;
			var thispaperScroller = this.paperScroller;
			var id = evt.target.attributes[0].nodeValue;
			
			if(id=='javascript:void(0)'){
				id = evt.target.attributes[2].nodeValue;
			}	
			
			$('.loadproject').css('font-weight','normal');
			$('.loadproject[data-id="'+id+'"]').css('font-weight','bold');
			
			if(prev_id!=id){
				$.post(_dom_url+'index.php?r=automation/loadproject',{id:id},function(res){
					thisgraph.fromJSON(JSON.parse(res.data));
					$('#projname').val(res.name);
					$('#btn-delete').show();
					$('#current_id').val(id);
					
					thispaperScroller.centerContent();
					
					prev_id = id;
				});
			}
			

		}, this));
		$('#btn-delete').on('click', function() {
			var id = $('#current_id').val();
			$.post(_dom_url+'index.php?r=automation/deleteproject',{id:id},function(res){
				window.location.href=window.location.href;
			});
		});
		$('#btn-projselect').on('change', _.bind(function (evt){
			var option = evt.target.value;
			var thisgraph = this.graph;			
			var jsonString  = JSON.stringify(thisgraph);
			
			
			if(option=='btn-save'){
				
				if(jsonString == '{"cells":[]}'){
					alert('Workflow is empty!');
				}else{
					var projname = $('#projname').val();
					if (projname!='') {
						$.post(_dom_url+'index.php?r=automation/saveproject/',{name:projname,graphdata:jsonString},function(res){
							alert('Successfully saved!');
							window.location.href=window.location.pathname +'?id='+res.id;
						});
					}else{
						alert('Workflow name is required.');
						$('#projname').focus();
					}
				}	
				
			}else if(option=='btn-createnew'){
				window.location.href=window.location.pathname;
			}else if(option=='btn-delete'){
				var id = $('#current_id').val();
				if(id!=''){
					$.post(_dom_url+'index.php?r=automation/deleteproject',{id:id},function(res){
						window.location.href=window.location.pathname +'?d=load';
					});
				}else{
					alert('Select a workflow project to delete.');
				}
			}else if(option=='btn-viewall'){
				$('.stenciltabproject').show();
				$('.stenciltabtrigger').hide();
				
				$('.group').hide();					
				$('.listofprojects').show();
			}else if(option=='btn-updateworkflow'){
				var current_id = $('#current_id').val();
				$.post(_dom_url+'index.php?r=automation/getworkflowtype',{id:current_id},function(res){
					if(res.type=='guide'){
						var tagsli = '';
						for(x=0; x<(res.tags).length; x++){
							tagsli += '<li class="taglist tagselected"><span class="tagvalue">'+res.tags[x].tag+'</span> <a href="javascript:void(0);" class="tagdelete">x</a></li>';
						}
						saveguidetemplate(jsonString,res.name,res.cat,tagsli,res.desc,res.thumb,res.wtid);
					}else{
						var projname = $('#projname').val();
						if (projname!='') {
							$.post(_dom_url+'index.php?r=automation/saveproject',{name:projname,graphdata:jsonString,current_id:current_id},function(res){
								alert('Successfully saved!');
								//window.location.href=window.location.pathname +'?id='+res.id;
							});
						}else{
							alert('Workflow name is required.');
							$('#projname').focus();
						}
					}
				});
			}else if(option=='btn-saveguide'){
				saveguidetemplate(jsonString);
			}
			$('#btn-projselect').val('');
		}, this));	
		
		function saveguidetemplate(jsonString='',wname='',wcat='',wtags='',wdesc='',wthumb='',wtid){			
			var current_id = $('#current_id').val();
			var modalTitle = 'Modify Template Guide';
			if(current_id==''){
				current_id = 0;
				modalTitle = 'Save as Template Guide';
			}
			if(wthumb=='') wthumb = _dom_url+'images/guides/blank.gif';
			var tagflag = false;
			var content = '<table class="saveguide"><tbody><tr><td style="width:150px"><span class="red">*</span> Template Name :</td><td><input type="text" id="tem_name" value="'+wname+'"></td></tr><tr><td><span class="red">*</span> Category :</td><td><select id="tem_category" style="width:98.5%"><option value="">-- select--</option></select></td></tr><tr><td>Tags :<br><small>(separate with a comma)</small></td><td><ul class="tag_list"><li class="taglist" style="display:block"><input type="text" id="tem_tags" placeholder="enter keyword..."/></li>'+wtags+'</ul></td></tr><tr><td><span class="red">*</span> Description :</td><td><textarea id="tem_desc">'+wdesc+'</textarea></td></tr><tr><td>Thumbnail :<br><small>(must not exceed 100KB)</small></td><td><div id="tem_thumb_prev"><img style="width: 100%;" src="'+wthumb+'"></div><input type="file" id="tem_thumb" name="thumbnail" multiple /></td></tr></tbody></table><br><div id="tem_thumb_error"></div><button id="saveguidebtn">Save Guide</button><input type="hidden" id="tem_thumb_path" value="'+wthumb+'"><input type="hidden" id="tem_wtid" value="'+wtid+'">';
			var dialog = new joint.ui.Dialog({
				width: '600px',
				type: 'neutral',
				draggable: true,
				title: modalTitle,
				content: content
			});
			dialog.open();
			
			$.post(_dom_url+'index.php?r=automation/getallcategories',{},function(res){
				var categories = res.categories
				var categories_arr = $.map(categories, function(el) { return el });
				for(i=0; i<categories_arr.length; i++){
					var cid = categories_arr[i]['c_id'];		
					var cname = categories_arr[i]['c_name'];
					if(wcat==cid)
						var opt = '<option value="'+cid+'" selected >'+cname+'</option>';
					else
						var opt = '<option value="'+cid+'">'+cname+'</option>';
					$('#tem_category').append(opt);
				}
			});
			
			$('#tem_thumb').fileupload({
				url: _dom_url+'index.php?r=automation/uploadthumb',
				dataType: 'json',
				add: function (e, data) {
					$('#tem_thumb').addClass('loading');	
					$('#tem_thumb_error').html('');	
					data.submit();
				},
				done: function (e, data) {	
					//console.log(data.result);
					if(data.result.error!='0'){
						$('#tem_thumb_error').html(data.result.error);	
					}else{
						$('#tem_thumb_prev').html('<img src="'+_dom_url+'images/guides/'+data.result.path+'" style="width:100%;" />');	
						$('#tem_thumb_path').val(_dom_url+'images/guides/'+data.result.path);	
					}	
					$('#tem_thumb').removeClass('loading');
				}
			});
			
			$('#tem_tags').easyAutocomplete({
				url: function(phrase) {
					return _dom_url+'index.php?r=automation/gettagsbykey';
				},
				getValue: function(element) {
					return element.tag;
				},
				ajaxSettings: {
					dataType: "json",
					method: "POST",
					data: {
					  dataType: "json"
					}
				},
				preparePostData: function(data) {
					data.phrase = $("#tem_tags").val();						
					return data;
				},
				list: {
					onChooseEvent: function() {
						var tag = $("#tem_tags").val();
						if(tag!=''){
							$('ul.tag_list').append('<li class="taglist tagselected"><span class="tagvalue">'+tag+'</span> <a href="javascript:void(0);" class="tagdelete">x</a></li>');
							$("#tem_tags").val('');
							$("#tem_tags").removeClass('loading');
							$("#tem_tags").focus();
						}							
					},
					onShowListEvent: function() {
						console.log(tagflag);
						if(tagflag){
							$('#eac-container-tem_tags').find('ul').css('display','none');
							tagflag = false;
						}
					}
				},
				requestDelay: 1000
			});
			$( document ).on( "click", ".tagdelete", function() {
				$(this).parent().remove();
			});
			
			$( "#tem_tags" ).keyup(function( event ) {
				if(event.which==188){	
					var tag = $("#tem_tags").val();	
					tag = tag.replace(',','');
					if(tag!=''){
						$('ul.tag_list').append('<li class="taglist tagselected"><span class="tagvalue">'+tag+'</span> <a href="javascript:void(0);" class="tagdelete">x</a></li>');
						$("#tem_tags").removeClass('loading');
						$("#tem_tags").val('');
						$("#tem_tags").focus();
					}
					tagflag = true;
					
				}else{
					$("#tem_tags").addClass('loading');
				}
			});
			
			
			$('#saveguidebtn').on('click',function(){		
				var tem_wtid = $('#tem_wtid').val();
				var tem_name = $('#tem_name').val();
				var tem_tags = $('#tem_tags').val();
				var tem_desc = $('#tem_desc').val();
				var tem_thumb = $('#tem_thumb_path').val();
				var tem_category = $('#tem_category').val();
				var taglist = [];
				
				$( ".tagvalue" ).each(function( index ) {
					var tag = $( this ).text();
					taglist.push(tag);
				});

				if(tem_name=='') {
					alert('Template name is required.');
					$('#tem_name').focus();
				}else if(tem_category=='') {
					alert('Category is required.');
					$('#tem_category').focus();
				}else if(tem_desc=='') {
					alert('Description is required.');
					$('#tem_desc').focus();
				}else{ 
					$('#tem_thumb_error').html('Please wait...saving data...');
					$.post(_dom_url+'index.php?r=automation/savetemplateguide',{current_id:current_id,category:tem_category,taglist:taglist,name:tem_name,desc:tem_desc,tags:tem_tags,thumb:tem_thumb,graphdata:jsonString,wtid:tem_wtid},function(res){
						alert('Successfully saved!');
						window.location.href=window.location.pathname +'index.php?r=guide';
					});
				}
			});
			
		}
		
		var $zoomLevel = $('#zoom-level');
        var $zoomRange = $('#zoom-range');
        var $zoomRangeBefore = $('#zoom-range-before');
		
		$('#zoom-range').on('change', _.bind(function(evt) { 
			var thispaperScroller = this.paperScroller;
			var range = $zoomRange.val();
			var range_before = $zoomRangeBefore .val();			
			var difference = parseFloat(parseInt(range) - parseInt(range_before))/100;
			
			if(difference>-0.1){
				thispaperScroller.zoom(difference, { max: 5, grid: 0.2 }); 
			}				
			else{
				thispaperScroller.zoom(difference, { min: .2, grid: 0.2 }); 
			}
		}, this));

        
        this.paper.on('scale', function(scale) {
            $zoomLevel.text(Math.round(scale * 100));
            $zoomRange.val(Math.round(scale * 100));
            $zoomRangeBefore.val(Math.round(scale * 100));
        });
		$zoomRange.val(100);
        $zoomRangeBefore.val(100);
		
		$('#btn-zoom-in').trigger('click');
    },

    initializeToolbarTooltips: function() {
        
        $('.toolbar-container [data-tooltip]').each(function() {
            
            new joint.ui.Tooltip({
                target: $(this),
                content: $(this).data('tooltip'),
                bottom: '.toolbar-container',
				direction: 'bottom'
            });
        });
    },

    toggleFullscreen: function() {

        var el = document.body;

        function prefixedResult(el, prop) {
            
            var prefixes = ['webkit', 'moz', 'ms', 'o', ''];
            for (var i = 0; i < prefixes.length; i++) {
                var prefix = prefixes[i];
                var propName = prefix ? (prefix + prop) : (prop.substr(0, 1).toLowerCase() + prop.substr(1));
                if (!_.isUndefined(el[propName])) {
                    return _.isFunction(el[propName]) ? el[propName]() : el[propName];
                }
            }
        }

        if (prefixedResult(document, 'FullScreen') || prefixedResult(document, 'IsFullScreen')) {
            prefixedResult(document, 'CancelFullScreen');
        } else {
            prefixedResult(el, 'RequestFullScreen');
        }
    },

    setGrid: function(gridSize) {

        this.paper.options.gridSize = gridSize;
        
        var backgroundImage = this.getGridBackgroundImage(gridSize);
        this.paper.$el.css('background-image', 'url("' + backgroundImage + '")');
    },

    getGridBackgroundImage: function(gridSize, color) {

        var canvas = $('<canvas/>', { width: gridSize, height: gridSize });

        canvas[0].width = gridSize;
        canvas[0].height = gridSize;

        var context = canvas[0].getContext('2d');
        context.beginPath();
       
		
		context.strokeStyle  = '#f3f3f3';
		context.strokeRect(.5, .5, gridSize, gridSize);
        context.stroke(); 
		
		context.rect(.5, .5, 1, 1);
        context.fillStyle = color || '#aaaaaa';
        context.fill();

        return canvas[0].toDataURL('image/png');
    },

    initializeChannel: function(url) {
        // Example usage of the Channel plugin. Note that this assumes the `node channelHub` is running.
        // See the channelHub.js file for furhter instructions.

        var room = (location.hash && location.hash.substr(1));
        if (!room) {
            room = joint.util.uuid();
            this.navigate('#' + room);
        }

        var channel = this.channel = new joint.com.Channel({ graph: this.graph, url: url || 'ws://localhost:4141', query: { room: room } });
        console.log('room', room, 'channel', channel.id);

        var roomUrl = location.href.replace(location.hash, '') + '#' + room;
        $('.statusbar-container .rt-colab').html('Send this link to a friend to <b>collaborate in real-time</b>: <a href="' + roomUrl + '" target="_blank">' + roomUrl + '</a>');
    },

	
});
