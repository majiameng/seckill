<?php
	class common{
        /**
         * Description:  渲染页面
         * Author: JiaMeng <666@majiameng.com>
         * Updater:
         * @param string $view
         * @param array $data
         * @throws Exception
         */
		protected function render($view='',$data=[]){
			$viewpath 	= SEC_ROOT_PATH .'/view/';
			$viewfile 	= $viewpath . ($view ? $view : CONTROLLER . '/' .ACTION ) .'.php';
			if(is_file($viewfile)){
		        // 页面缓存
				ob_start();
				ob_implicit_flush(0);
				// 模板阵列变量分解成为独立变量
				extract($data, EXTR_OVERWRITE);
				include $viewfile;
				// 获取并清空缓存
				$content = ob_get_clean();
				echo $content;
			}else{
				throw new Exception("模板文件不存在");
			}
		}

        /**
         * Description:  ajax 返回
         * Author: JiaMeng <666@majiameng.com>
         * Updater:
         * @param $data
         */
		protected function ajaxreturn($data){
			$return = json_encode($data);
			exit($return);
		}
	}