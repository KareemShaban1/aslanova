export function materialConfigValidation(json) {
	if (typeof json !== 'object' || json === null) {
		throw new Error('There is no config file');
	}

	if (!json.textures) {
		throw new Error('The textures is required');
	}

	const nameOfMaterials = Object.keys(json).filter((e) => e !== 'textures' && e !== 'subGroups');

	for (const name of nameOfMaterials) {
		if (name.indexOf('M-') !== 0) {
			throw new Error(`The ${name} material should start with 'M-'`);
		}

		const item = json['textures'][name];

		if (!item) {
			throw new Error(`There is no textures for the ${name} material`);
		}

		if (item.length) {
			for (const texture of item) {
				if (!texture.url) {
					throw new Error(`The textures.${name} have texture without url property`);
				}
			}
		} else {
			for (const [key, subGroup] of Object.entries(item)) {
				if (!subGroup.length) {
					throw new Error(`The textures.${name}.${key} should be an array`);
				}

				for (const texture of subGroup) {
					if (!texture.url) {
						throw new Error(`The textures.${name}.${key} have texture without url property`);
					}
				}

				if (!json.subGroups) {
					throw new Error("There must be 'subGroups' property");
				}

				if (!json.subGroups[key]) {
					throw new Error(`There must be ${key} property inside the subGroups`);
				}

				if (typeof json.subGroups[key] !== 'string') {
					throw new Error(`The ${key} property inside the subGroups must be string`);
				}
			}
		}
	}

	return true;
}
