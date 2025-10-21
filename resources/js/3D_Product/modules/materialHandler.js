import handler from './handler';
import { convertFromArrayToObj, setCallBackToElementOrObj } from './helpers';

export default class extends handler {
	constructor(config, api, callBack, vw) {
		super(config, api);

		this.materials = null;
		this.vw = vw;

		this.getMaterials(callBack);
	}

	getMaterials(callBack) {
		this.api.getMaterialList((err, mainMaterials) => {
			if (err) {
				throw err;
			}

			let materials = [];
			for (let [_, material] of Object.entries(mainMaterials)) {
				if (material.name.indexOf('M-') == 0) {
					materials.push(material);
				}
			}

			this.materials = materials;

			const temp = convertFromArrayToObj(materials, 'name');

			this.materials = this.margeToGroup(temp);
			for (const [key, _] of Object.entries(this.materials)) {
				this.materials[key].textures = this.getTexturesList(key);
			}

			callBack(this.materials);
		});
	}

	getTexturesList(materialName) {
		return this.config['textures'][materialName];
	}

	getMaterialName(materialName) {
		return this.config[materialName] || {};
	}

	getSubGroups(name) {
		return this.config['subGroups'][name];
	}

	selectTexture(material, texture) {
		this.vw.updatingLoader = true;
		this.vw.selectedTextures[material.name] = texture.url;

		this.api.addTexture(texture.url, (err, id) => {
			if (err) {
				this.vw.updatingLoader = false;
				throw err;
			}

			const setTheTexture = (m) => {
				m.channels.GlossinessPBR.factor = material.baseColor;
				m.channels.AlbedoPBR.factor = material.glossiness;
				m.channels.AlbedoPBR.enable = true;
				m.channels.AlbedoPBR.color = false;
				m.channels.AlbedoPBR.texture = {};
				m.channels.AlbedoPBR.texture.uid = id;


				this.api.setMaterial(JSON.parse(JSON.stringify(m)));
			};

			setCallBackToElementOrObj(material, setTheTexture, 'name');
			this.vw.updatingLoader = false;
		});
	}
}
