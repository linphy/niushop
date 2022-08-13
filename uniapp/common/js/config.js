var config = {

	// api请求地址
	baseUrl: '{{$baseUrl}}',

	// 图片域名
	imgDomain: '{{$imgDomain}}',

	// H5端域名
	h5Domain: '{{$h5Domain}}',

	// 腾讯地图key
	mpKey: '{{$mpKey}}',

	//客服地址
	webSocket: '{{$webSocket}}',

	//本地端主动给服务器ping的时间, 0 则不开启 , 单位秒
	pingInterval: 1500,

};

export default config;
