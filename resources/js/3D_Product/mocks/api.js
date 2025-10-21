export const product = {
	id: 1,
	name: 'product name',
	price: '200.00',
	model_id: 0,
	created_at: null,
	updated_at: null,
	parts: [
		{
			id: 1,
			name: 'Angled leg',
			image_url: 'https://image.jpg',
			price: '20.00',
			'3d_name': 'L-Legs1',
			created_at: null,
			updated_at: null,
			pivot: {
				product_id: 1,
				part_id: 1,
			},
		},
		{
			id: 12312,
			name: 'Straight leg',
			image_url: 'https://image.jpg',
			price: '20.00',
			'3d_name': 'L-Legs2',
			created_at: null,
			updated_at: null,
			pivot: {
				product_id: 1,
				part_id: 1,
			},
		},
		{
			id: 9,
			name: 'Straight hand',
			image_url: 'https://image.jpg',
			price: '22.00',
			'3d_name': 'H-hand',
			created_at: null,
			updated_at: null,
			pivot: {
				product_id: 1,
				part_id: 9,
			},
		},
	],
	textures: [
		{
			id: 122,
			name: 'Walnut wood',
			url: 'https://pub-779400cd8ce9428aad58d759f7c1e17a.r2.dev/CP_F_1.jpg',
			price: '50.00',
			material_id: 912,
			base_color: '', // new
			glossiness: '0.00', // new
			created_at: '2024-08-30T20:31:10.000000Z',
			updated_at: '2024-08-30T20:31:10.000000Z',
			pivot: {
				product_id: 1,
				texture_id: 122,
			},
		},
		{
			id: 123,
			name: 'Oak wood',
			url: 'https://textures.jpg',
			price: '50.00',
			material_id: 912,
			base_color: '', // new
			glossiness: '0.00', // new
			created_at: '2024-08-30T20:31:10.000000Z',
			updated_at: '2024-08-30T20:31:10.000000Z',
			pivot: {
				product_id: 1,
				texture_id: 123,
			},
		},
		{
			id: 124,
			name: 'Linen',
			url: 'https://textures.jpg',
			price: '50.00',
			material_id: 914,
			base_color: '', // new
			glossiness: '0.00', // new
			created_at: '2024-08-30T20:31:10.000000Z',
			updated_at: '2024-08-30T20:31:10.000000Z',
			pivot: {
				product_id: 1,
				texture_id: 124,
			},
		},
		{
			id: 125,
			name: 'Leather',
			url: 'https://textures.jpg',
			price: '50.00',
			material_id: 915,
			base_color: '', // new
			glossiness: '0.00', // new
			created_at: '2024-08-30T20:31:10.000000Z',
			updated_at: '2024-08-30T20:31:10.000000Z',
			pivot: {
				product_id: 1,
				texture_id: 125,
			},
		},
	],
};

export const materials = [
	{
		id: 912,
		name: 'Wood',
		'3d_name': 'M-wood',
		order: 2,
		parent_id: null,
		created_at: '2024-08-30T20:30:46.000000Z',
		updated_at: '2024-08-30T20:30:46.000000Z',
		textures: [
			{
				id: 122,
				name: 'Walnut wood',
				url: 'https://textures.jpg',
				price: '50.00',
				material_id: 912,
				created_at: '2024-08-30T20:31:10.000000Z',
				updated_at: '2024-08-30T20:31:10.000000Z',
			},
			{
				id: 123,
				name: 'Oak wood',
				url: 'https://textures.jpg',
				price: '50.00',
				material_id: 912,
				created_at: '2024-08-30T20:31:10.000000Z',
				updated_at: '2024-08-30T20:31:10.000000Z',
			},
		],
		children: [],
	},
	{
		id: 913,
		name: 'Fabric',
		'3d_name': 'M-fabric',
		order: 1,
		parent_id: null,
		created_at: '2024-08-30T20:30:46.000000Z',
		updated_at: '2024-08-30T20:30:46.000000Z',
		textures: [],
		children: [
			{
				id: 914,
				name: 'Soft fabric',
				'3d_name': 'Soft_Fabric',

				order: 1,
				parent_id: 913,
				created_at: '2024-08-30T20:30:46.000000Z',
				updated_at: '2024-08-30T20:30:46.000000Z',
			},
			{
				id: 915,
				name: 'Hard fabric',
				'3d_name': 'Hard_Fabric',

				order: 2,
				parent_id: 913,
				created_at: '2024-08-30T20:30:46.000000Z',
				updated_at: '2024-08-30T20:30:46.000000Z',
			},
		],
	},
	{
		id: 914,
		name: 'Soft fabric',
		'3d_name': 'Soft_Fabric',
		order: 1,
		parent_id: 913,
		created_at: '2024-08-30T20:30:46.000000Z',
		updated_at: '2024-08-30T20:30:46.000000Z',
		textures: [
			{
				id: 124,
				name: 'Linen',
				url: 'https://textures.jpg',
				price: '50.00',
				material_id: 914,
				created_at: '2024-08-30T20:31:10.000000Z',
				updated_at: '2024-08-30T20:31:10.000000Z',
			},
		],
		children: [],
	},
	{
		id: 915,
		name: 'Hard fabric',
		'3d_name': 'Hard_Fabric',
		order: 2,
		parent_id: 913,
		created_at: '2024-08-30T20:30:46.000000Z',
		updated_at: '2024-08-30T20:30:46.000000Z',
		textures: [
			{
				id: 125,
				name: 'Leather',
				url: 'https://textures.jpg',
				price: '50.00',
				material_id: 915,
				created_at: '2024-08-30T20:31:10.000000Z',
				updated_at: '2024-08-30T20:31:10.000000Z',
			},
		],
		children: [],
	},
];
