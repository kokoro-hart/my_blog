/**
 * @modules : node_modulesフォルダまでの絶対パスのエイリアス
 * webpack.config.jsにて定義している
 */

//SVGスプライトをIEで使用するためのライブラリ
import '@modules/svgxuse';

//PrismJS
import './lib/prism';

//ダークテーマ切り替え
import './modules/theme.js';

import './common'