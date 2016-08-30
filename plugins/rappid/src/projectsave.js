/*! Rappid v1.7.2 - HTML5 Diagramming Framework - TRIAL VERSION

Copyright (c) 2015 client IO

 2016-07-06 


This Source Code Form is subject to the terms of the Rappid Trial License
, v. 2.0. If a copy of the Rappid License was not distributed with this
file, You can obtain one at http://jointjs.com/license/rappid_v2.txt
 or from the Rappid archive as was distributed by client IO. See the LICENSE file.*/


var Stencil = {};

Stencil.groups = {
    triggers: { index: 1, label: 'Trigger Events' },
};
/*
Stencil.groups = {
    basic: { index: 1, label: 'Basic shapes' },
    fsa: { index: 2, label: 'State machine' },
    pn: { index: 3, label: 'Petri nets' },
    erd: { index: 4, label: 'Entity-relationship' },
    uml: { index: 5, label: 'UML' },
    org: { index: 6, label: 'ORG' }
};*/

Stencil.shapes = {

    triggers: [
        new joint.shapes.basic.Rect({
            size: { width: 5, height: 3 },
            attrs: {
                rect: {
                    rx: 2, ry: 2, width: 50, height: 30,
                    fill: '#27AE60'
                },
                text: { text: 'rect', fill: '#ffffff', 'font-size': 10, stroke: '#000000', 'stroke-width': 0 }
            }
        }),
        new joint.shapes.basic.Circle({
            size: { width: 5, height: 3 },
            attrs: {
                circle: { width: 50, height: 30, fill: '#E74C3C' },
                text: { text: 'ellipse', fill: '#ffffff', 'font-size': 10, stroke: '#000000', 'stroke-width': 0 }
            }
        }),
        new joint.shapes.devs.Atomic({
            size: { width: 4, height: 3 },
            inPorts: ['in1','in2'],
            outPorts: ['out'],
            attrs: {
	        rect: { fill: '#8e44ad', rx: 2, ry: 2 },
                '.label': { text: 'model', fill: '#ffffff', 'font-size': 10, stroke: '#000000', 'stroke-width': 0 },
	        '.inPorts circle': { fill: '#f1c40f', opacity: 0.9 },
                '.outPorts circle': { fill: '#f1c40f', opacity: 0.9 },
	        '.inPorts text, .outPorts text': { 'font-size': 9 }
            }
        }),
        new joint.shapes.basic.Image({
            attrs: {
                image: { width: 50, height: 50, 'xlink:href': 'data:image/png;base64,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' },
                text: { text: 'image', 'font-size': 9, display: '', stroke: '#000000', 'stroke-width': 0 }
            }
        })
    ],
    basic: [
        new joint.shapes.basic.Rect({
            size: { width: 5, height: 3 },
            attrs: {
                rect: {
                    rx: 2, ry: 2, width: 50, height: 30,
                    fill: '#27AE60'
                },
                text: { text: 'rect', fill: '#ffffff', 'font-size': 10, stroke: '#000000', 'stroke-width': 0 }
            }
        }),
        new joint.shapes.basic.Circle({
            size: { width: 5, height: 3 },
            attrs: {
                circle: { width: 50, height: 30, fill: '#E74C3C' },
                text: { text: 'ellipse', fill: '#ffffff', 'font-size': 10, stroke: '#000000', 'stroke-width': 0 }
            }
        }),
        new joint.shapes.devs.Atomic({
            size: { width: 4, height: 3 },
            inPorts: ['in1','in2'],
            outPorts: ['out'],
            attrs: {
	        rect: { fill: '#8e44ad', rx: 2, ry: 2 },
                '.label': { text: 'model', fill: '#ffffff', 'font-size': 10, stroke: '#000000', 'stroke-width': 0 },
	        '.inPorts circle': { fill: '#f1c40f', opacity: 0.9 },
                '.outPorts circle': { fill: '#f1c40f', opacity: 0.9 },
	        '.inPorts text, .outPorts text': { 'font-size': 9 }
            }
        }),
        new joint.shapes.basic.Image({
            attrs: {
                image: { width: 50, height: 50, 'xlink:href': 'data:image/png;base64,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' },
                text: { text: 'image', 'font-size': 9, display: '', stroke: '#000000', 'stroke-width': 0 }
            }
        })
    ],
    fsa: [
        new joint.shapes.fsa.StartState,
        new joint.shapes.fsa.EndState,
        new joint.shapes.fsa.State({ attrs: { text: { text: 'state' } } })
    ],
    pn: [
        new joint.shapes.pn.Place({ tokens: 3 }),
        new joint.shapes.pn.Transition({ attrs: { '.label': { text: 'transition' }} })
    ],
    erd: [
        new joint.shapes.erd.Entity({ attrs: { text: { text: 'Entity' } } }),
        new joint.shapes.erd.WeakEntity({ attrs: { text: { text: 'Weak entity', 'font-size': 10 } } }),
        new joint.shapes.erd.IdentifyingRelationship({ attrs: { text: { text: 'Relation', 'font-size': 8 } } }),
        new joint.shapes.erd.Relationship({ attrs: { text: { text: 'Relation' } } }),
        new joint.shapes.erd.ISA({ attrs: { text: { text: 'ISA' } } }),
        new joint.shapes.erd.Key({ attrs: { text: { text: 'Key' } } }),
        new joint.shapes.erd.Normal({ attrs: { text: { text: 'Normal' } } }),
        new joint.shapes.erd.Multivalued({ attrs: { text: { text: 'MultiValued', 'font-size': 10 } } }),
        new joint.shapes.erd.Derived({ attrs: { text: { text: 'Derived' } } })
    ],
    uml: [
        new joint.shapes.uml.Class({ name: 'Class', attributes: ['+attr1'], methods: ['-setAttr1()'], attrs: { '.uml-class-name-text': { 'font-size': 9 }, '.uml-class-attrs-text': { 'font-size': 9 }, '.uml-class-methods-text': { 'font-size': 9 } } }),
        new joint.shapes.uml.Interface({ name: 'Interface', attributes: ['+attr1'], methods: ['-setAttr1()'], attrs: { '.uml-class-name-text': { 'font-size': 9 }, '.uml-class-attrs-text': { 'font-size': 9 }, '.uml-class-methods-text': { 'font-size': 9 } } }),
        new joint.shapes.uml.Abstract({ name: 'Abstract', attributes: ['+attr1'], methods: ['-setAttr1()'], attrs: { '.uml-class-name-text': { 'font-size': 9 }, '.uml-class-attrs-text': { 'font-size': 9 }, '.uml-class-methods-text': { 'font-size': 9 } } }),
        new joint.shapes.uml.State({ name: 'State', events: ['entry/','create()'], attrs: { '.uml-state-name': { 'font-size': 10 }, '.uml-state-events': { 'font-size': 10 } } })
    ],
    org: [
        new joint.shapes.org.Member({ attrs: { '.rank': { text: 'Rank' }, '.name': { text: 'Name' }, image: { 'xlink:href': 'data:image/png;base64,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' } } })
    ]
};
