export default class {
	constructor(config, api) {
		this.config = config;
		this.api = api;
	}

	/**
	 * @param {{name: "X_N"}[]} arr
	 * @returns
	 */
	convertToObj(arr) {
		const temp = {};
		for (const ele of arr) {
			temp[ele.name] = ele;
		}

		return this.margeToGroup(temp);
	}

	margeToGroup(items) {
		const leaf = {};
		const subs = {};
		for (let [key, node] of Object.entries(items)) {
			if (key.includes('_')) {
				subs[key] = node;
			} else {
				leaf[key] = node;
			}
		}

		const temp = {};
		for (let [key, node] of Object.entries(subs)) {
			const groupName = key.split('_')[0];

			if (temp[groupName]) {
				temp[groupName][key] = node;
			} else {
				temp[groupName] = { [key]: node };
			}
		}

		return { ...leaf, ...temp };
	}
}
