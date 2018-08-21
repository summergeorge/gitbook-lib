<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublisherInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publisherInfo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('description');
            $table->string('github_url')->nullable();
            $table->text('links')->nullable();
            $table->text('versions_select')->nullable();
            $table->text('edit_link')->nullable();
            $table->string('web_dir')->unique()->comment('文档目录地址（不可重复）');
            $table->string('git_url')->comment('git clone地址')->nullable();
            $table->string('git_branch')->comment('git分支')->nullable();
            $table->string('git_path')->comment('summary所在的目录')->nullable();
            $table->string('git_user')->comment('git用户名')->nullable();
            $table->string('git_password')->comment('git密码')->nullable();
            $table->text('book_json')->comment('自定义json信息')->nullable();
            $table->string('token')->index()->comment('token')->nullable();

            $table->boolean('cache')->comment('是否启用git clone缓存');
            $table->boolean('change_zh')->comment('是否进行中文图片转化');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('publisherInfo');
    }
}
