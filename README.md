# ServerBackUp
[![PoggitCI Badge](https://poggit.pmmp.io/ci.badge/gamesukimanIRS/ServerBackUp/ServerBackUp)](https://poggit.pmmp.io/ci/gamesukimanIRS/ServerBackUp)

[ダウンロード](https://poggit.pmmp.io/ci/gamesukimanIRS/ServerBackUp/ServerBackUp) 一番上のビルドの一番右のDownloadから。 
[現在の安定版のダウンロード](https://poggit.pmmp.io/r/20037/ServerBackUp_dev-8.phar)

players、worlds、plugins、ops.txt、whitelist.txt、banned-players.txt、banned-ips.txtを定期的にバックアップします。  
バックアップしたデータはconfigフォルダと同じ場所にバックアップした時間ごとに保存されています。  
バックアップ間隔はconfigで分単位で設定できます。また、定期的バックアップをオフにすることもできます。  
`/backup`で手動バックアップも可能です。定期バックアップをオフにしている場合はこれを利用してください。  
尚、pluginsフォルダ内のこのプラグインのフォルダ、KillBearBoysのフォルダはバックアップされないため、無駄にデータがかさばることはありません。
仕様上、極稀にバックアップされないフォルダが存在する場合があります。  

### 注意事項
各データがとてもかさばりますので、代行鯖を利用している方は事前に代行主の方に確認をとってください。  
いらないバックアップは定期的な削除をお薦めします。  
このプラグインでデータにいかなる損害が発生しても責任は負いません。ですが、バグがあった際はご報告願います。

### スペシャルサンクス
ogiwara様 - ファイルコピー機能参考

### ライセンス・謝辞
GPL-3.0 license  
使用時はクレジットがあると喜びます。
また、製作者はソースを使用して発生した問題の責任は負いかねます。  
製作者は勝手にこのレポジトリを削除する場合があります。  
私にプラグインについての知識をご教授くださった皆様にここで感謝申し上げます。
