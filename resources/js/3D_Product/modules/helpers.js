export const setCallBackToElementOrObj = (obj, callback, condition, ...params) => {
	if (obj[condition] !== void 0) {
		callback(obj, ...params);
	} else {
		for (const [_, ele] of Object.entries(obj)) {
			if (ele[condition] !== void 0) callback(ele, ...params);
		}
	}
};

export const getTheFirstElementFromObj = (obj) => {
	return Object.values(obj)[0];
};

export const convertFromArrayToObj = (arr, key) => {
	const temp = {};
	for (const ele of arr) {
		temp[ele[key]] = ele;
	}
	return temp;
};

export const convertFromObjToArray = (obj) => {
	return Object.values(obj);
};
