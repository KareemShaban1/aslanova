import handler from './handler';
import { getTheFirstElementFromObj, setCallBackToElementOrObj } from './helpers';
import { configConfigWithNodes } from './nodeValidation';

export default class extends handler {
	constructor(config, api, callBack, vw) {
		super(config, api);

		this.nodes = null;
		this.vw = vw;
		this.haveRotatable = false;

		this.getNodes(callBack);
	}

	getNodes(callBack) {
		this.api.getNodeMap((err, mainNodes) => {
			if (err) {
				throw err;
			}

			const nodes = [];
			for (let [_, node] of Object.entries(mainNodes)) {
				if (node.type === 'MatrixTransform') {
					node.shown = true;
					if (node.name.indexOf(':') !== -1) {
						const temp = node.name.split(':');
						node.name = temp[0];
						if (temp[1] === 'm') {
							node.rotatable = true;
							this.haveRotatable = true;
						}
					}
					nodes.push(node);
				}
			}

			this.nodes = nodes;

			configConfigWithNodes(this.config, this.sortTheNodesToNaming(nodes));

			callBack(this.sortTheNodes(nodes));
		});
	}

	sortTheNodes(nodes) {
		const sortedNodes = this.sortTheNodesToNaming(nodes);

		const alwaysShow = this.convertToObj(sortedNodes.A);
		const toggle = this.convertToObj(sortedNodes.V);
		const lists = this.getList(sortedNodes.C);

		return { nodes, sortedNodes, alwaysShow, toggle, lists };
	}

	getList(nodes) {
		// marge the nodes under the name of its group
		const list = nodes.reduce((p, c) => {
			const groupName = c.name.split('-')[0];

			if (p[groupName]) {
				p[groupName][c.name] = c;
			} else {
				p[groupName] = {
					[c.name]: c,
				};
			}

			return p;
		}, {});

		// marge the nodes to group
		const temp = {};
		for (let [key, item] of Object.entries(list)) {
			temp[key] = this.margeToGroup(item);
		}

		// change the shown property to be true for first item and false for others
		for (let [_, list] of Object.entries(temp)) {
			Object.entries(list).forEach(([_, item], i) => {
				setCallBackToElementOrObj(
					item,
					(ele, value) => {
						const changeTheShownOfMainNode = (e, value) => {
							this.nodes.find((n) => n.instanceID === e.instanceID).shown = value;
						};
						ele.shown = value;
						changeTheShownOfMainNode(ele, value);
					},
					'instanceID',
					i === 0,
				);
			});
		}

		this.updateTheApiShown();
		return temp;
	}

	sortTheNodesToNaming(nodes) {
		const A = [],
			V = [],
			C = [],
			G = [];

		for (const node of nodes) {
			switch (node.name[0]) {
				case 'A':
					A.push({ ...node, name: node.name.slice(2) });
					continue;
				case 'V':
					V.push({ ...node, name: node.name.slice(2) });
					continue;
				case 'C':
					C.push({ ...node, name: node.name.slice(2) });
					continue;
				case 'G':
					G.push({ ...node, name: node.name.slice(2) });
					continue;
			}
		}
		return { A, V, C, G };
	}

	getListName(node) {
		return this.config.lists[node];
	}
	getNodeName(node) {
		if (typeof node.instanceID === 'number') {
			return this.config.naming[node.name];
		} else {
			return this.config.naming[getTheFirstElementFromObj(node).name.split('_')[0]];
		}
	}
	getMainNode(id) {
		return this.nodes.find((e) => e.instanceID === id);
	}
	hideNode(node) {
		setCallBackToElementOrObj(
			node,
			(ele) => {
				this.getMainNode(ele.instanceID).shown = false;
			},
			'instanceID',
		);
		this.updateTheApiShown();
	}
	showNode(node) {
		setCallBackToElementOrObj(
			node,
			(ele) => {
				this.getMainNode(ele.instanceID).shown = true;
			},
			'instanceID',
		);
		this.updateTheApiShown();
	}
	toggleNode(node) {
		setCallBackToElementOrObj(
			node,
			(ele) => {
				if (this.getMainNode(ele.instanceID).shown) {
					this.hideNode(ele);
				} else {
					this.showNode(ele);
				}
			},
			'instanceID',
		);
	}
	updateTheApiShown() {
		this.vw.partSelected(this.nodes);

		this.nodes.forEach((n) => {
			if (n.shown) {
				this.api.show(n.instanceID);
			} else {
				this.api.hide(n.instanceID);
			}
		});
	}

	rotateNodes(val) {
		var deg = (val / 1000) * Math.PI;

		this.nodes
			.filter((e) => e.rotatable)
			.forEach((e) => {
				this.api.rotate(e.instanceID, [deg, 1, 0, 0], {
					duration: 0.5,
					easing: 'easeingLinear',
				});
			});
	}
}
