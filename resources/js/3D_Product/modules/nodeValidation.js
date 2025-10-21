export function nodeConfigValidation(json) {
	if (typeof json !== 'object' || json === null) {
		throw new Error('There is no config file');
	}

	if (!json.naming) {
		throw new Error("There is no 'naming' property");
	}

	for (const [key, value] of Object.entries(json.naming)) {
		if (!value.url) {
			throw new Error(`The naming.${key} should have url property`);
		}

		if (typeof value.url !== 'string') {
			throw new Error(`The naming.${key} should be string`);
		}
	}

	if (json.lists) {
		for (const [key, value] of Object.entries(json.lists)) {
			if (typeof value !== 'string') {
				throw new Error(`The lists.${key} should be string`);
			}
		}
	}

	return true;
}

export function configConfigWithNodes(json, nodes) {
	for (var node of nodes.C) {
		if (node.name.split('-').length != 2) {
			throw new Error(
				`The ${node.name} node should be separated by '-'. where: {List name}-{Node name}`,
			);
		}

		if (node.name.includes('_') === -1) {
			if (!json['naming'][node.name]) {
				throw new Error(`There is no ${node.name} in the config.naming`);
			}
		} else {
			const mainNodeName = node.name.split('_')[0];
			if (!json['naming'][mainNodeName]) {
				throw new Error(`There is no ${mainNodeName} in the config.naming`);
			}
		}

		const groupName = node.name.split('-')[0];
		if (!json['lists'][groupName]) {
			throw new Error(`There is no ${groupName} in the config.lists`);
		}
	}
}
