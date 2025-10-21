export function fromApiToNodeConfig(product) {
	const naming = {};
	for (const part of product.parts) {
		naming[part['3d_name']] = {
			id: part.id,
			name: part.name,
			url: part.image_url,
			price: part.price,
		};
	}

	return {
		naming,
		lists: {
			L: 'Legs',
			H: 'Hands',
            Z: 'One Piece',
		},
	};
}

export function fromApiToMaterialConfig(materials, product) {
	const config = {};

	for (const material of materials.filter((e) => !e.parent_id)) {
		config[material['3d_name']] = {
			name: material.name,
			order: material.order,
		};
	}

	const getTexture = (texture) => ({
		id: texture.id,
		name: texture.name,
		price: texture.price,
		url: texture.url,
		baseColor: texture.base_color,
		glossiness: texture.glossiness,
	});

	const textures = {};
	for (const material of materials.filter((e) => !e.parent_id)) {
		textures[material['3d_name']] = product.textures
			.filter((e) => e.material_id == material.id)
			.map(getTexture);
	}

	for (const material of materials.filter((e) => e.parent_id)) {
		const parentMaterial = materials.find((e) => e.id == material.parent_id);

		if (textures[parentMaterial['3d_name']].length === 0) textures[parentMaterial['3d_name']] = {};

		textures[parentMaterial['3d_name']][material['3d_name']] = product.textures
			.filter((e) => e.material_id == material.id)
			.map(getTexture);
	}

	const subGroups = {};
	for (const material of materials.filter((e) => e.parent_id)) {
		subGroups[material['3d_name']] = material.name;
	}

	return { ...config, textures, subGroups };
}
