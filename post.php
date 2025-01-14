<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('includes/header.php');
?>
<?php $this->need('includes/body-layout.php');?>
<div class="hbox hbox-auto-xs hbox-auto-sm index">
    <div class="col center-part">
        <div class="article-container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php $this->options->siteUrl(); ?>">首页</a></li>
                    <?php if ($this->is('post')): ?>
                        <li class="breadcrumb-item active" aria-current="page"><?php $this->title() ?> ...</li>
                    <?php else: ?>
                        <li class="breadcrumb-item active"
                            aria-current="page"><?php $this->archiveTitle('&raquo;', '', ''); ?></li>
                    <?php endif; ?>
                </ol>
            </nav>
            <!--            头图-->
            <?php if ($this->fields->banner && $this->fields->banner != ''): ?>
                <div class="article-cover">
                    <div class="archive-cover-inner">
                        <img class="post-cover-img" src="<?php echo $this->fields->banner; ?>" alt="cover">
                    </div>
                </div>
            <?php endif; ?>
            <!--            内容-->
            <article class="post">
<!--                <h1 class="article-title"><a href="--><?php //$this->permalink() ?><!--">--><?php //$this->title() ?><!--</a></h1>-->
                <div class="article-auth">
                    <img class="avatar"
                         src="<?php echo getUserV2exAvatar($this->author->mail,$this->author->userAvatar) ?>"
                         alt="<?php $this->author() ?>"/>
                    <a href="<?php $this->author->permalink(); ?>"><span><?php $this->author(); ?></span></a>
                    <?php if ($this->user->hasLogin() && checkPermission($this->author->uid,$this->user->uid)): ?>
                        <a href="<?php $this->options->adminUrl('/write-post.php?cid='.$this->cid); ?>">编辑</a>
                        <?php Typecho_Widget::widget('Widget_Security')->to($security); ?>
                        <a href="<?php $security->index('/action/contents-post-edit?do=delete&cid='.$this->cid); ?>" onclick="javascript:return del_article(this,<?php _e($this->cid);?>)">删除</a>
                    <?php endif; ?>
                </div>
                <!--     元数据-->
                <div class="article-meta">
                    <span class="article-category">
                        <?php if (empty($this->category)) _e("未选择"); else $this->category(','); ?>
                    </span>
                    <time class="create-time" datetime="<?php $this->date('c'); ?>"><?php $this->date(); ?></time>
                    <?php $agree = $this->hidden ? array('agree' => 0, 'recording' => true) : utils::agreeNum($this->cid); ?>
                    <div class="article-data"><span><?php utils::getPostView($this); ?>阅读 <?php echo $agree['agree']; ?>点赞</span>
                    </div>
                </div>
                <div style="width:100%;overflow:hidden;max-height: 90px;"><?php _e($this->options->article_top_ads);?></div>

                    <!--     content-->
                <div class="article-content joe_detail__article">
                    <?php if ($this->options->JOverdue && $this->options->JOverdue !== 'off' && floor((time() - ($this->modified)) / 86400) > $this->options->JOverdue) : ?>
                        <div class="joe_detail__overdue">
                            <div class="joe_detail__overdue-wrapper">
                                <div class="title">
                                    <svg class="icon" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" width="20" height="20">
                                        <path d="M0 512c0 282.778 229.222 512 512 512s512-229.222 512-512S794.778 0 512 0 0 229.222 0 512z" fill="#FF8C00" fill-opacity=".51" />
                                        <path d="M462.473 756.326a45.039 45.039 0 0 0 41.762 28.74 45.039 45.039 0 0 0 41.779-28.74h-83.541zm119.09 0c-7.73 35.909-39.372 62.874-77.311 62.874-37.957 0-69.598-26.965-77.33-62.874H292.404a51.2 51.2 0 0 1-42.564-79.65l23.723-35.498V484.88a234.394 234.394 0 0 1 167.492-224.614c3.635-31.95 30.498-56.815 63.18-56.815 31.984 0 58.386 23.808 62.925 54.733A234.394 234.394 0 0 1 742.093 484.88v155.512l24.15 36.454a51.2 51.2 0 0 1-42.668 79.48H581.564zm-47.957-485.922c.069-.904.12-1.809.12-2.73 0-16.657-13.26-30.089-29.491-30.089-16.214 0-29.474 13.432-29.474 30.089 0 1.245.085 2.491.221 3.703l1.81 15.155-14.849 3.499a200.226 200.226 0 0 0-154.265 194.85v166.656l-29.457 44.1a17.067 17.067 0 0 0 14.182 26.556h431.155a17.067 17.067 0 0 0 14.234-26.487l-29.815-45.04V484.882A200.21 200.21 0 0 0 547.26 288.614l-14.985-2.986 1.331-15.224z" fill="#FFF" />
                                        <path d="M612.864 322.697c0 30.378 24.303 55.022 54.272 55.022 30.003 0 54.323-24.644 54.323-55.022 0-30.38-24.32-55.023-54.306-55.023s-54.306 24.644-54.306 55.023z" fill="#FA5252" />
                                    </svg>
                                    <span class="text">温馨提示：</span>
                                </div>
                                <div class="content">
                                    本文最后更新于<?php echo date('Y年m月d日', $this->modified); ?>，已超过<?php echo floor((time() - ($this->modified)) / 86400); ?>天没有更新，若内容或图片失效，请留言反馈。
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ($this->hidden || $this->titleshow): ?>
                        <form action="<?php echo Typecho_Widget::widget('Widget_Security')->getTokenUrl($this->permalink); ?>"
                              class="protected">
                            <div class="form-group mb-3 col-md-6 text-center required-password">
                                <label for="passwd">请输入密码访问</label>
                                <div class="input-group">
                                    <input type="password" id="passwd" name="protectPassword" class="form-control text"
                                           placeholder="请输入密码" aria-label="请输入密码">
                                    <input type="hidden" name="protectCid" value="<?php $this->cid(); ?>"/>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary protected-btn" type="button">提交</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    <?php else: ?>
                        <?php if ($this->fields->articleType == 'repost'):?>
                            <div><?php echo $this->fields->excerpt ?></div>
                            <?php _parseContent($this, $this->user->hasLogin()) ?>
                        <?php else: ?>
                            <?php _parseContent($this, $this->user->hasLogin()) ?>
                        <?php endif?>
                    <?php endif; ?>
                </div>
                <!--tag-->

<!--                <p class="tags">--><?php //$this->tags(' ', true, ''); ?><!--</p>-->
                <p class="license"><?php echo $this->options->LicenseInfo ? $this->options->LicenseInfo : '' ?></p>
                <!--点赞-->
                <div class="sc-AxjAm sc-AxirZ bseKGM">

                    <a href="<?php _e($this->categories[0]['permalink'])?>" class="sc-AxjAm bqBMQE hWYvmd">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"
                             class="dfDGBV">
                            <circle cx="10" cy="10" r="10" fill="#03A9F5"></circle>
                            <circle cx="10" cy="10" r="5" fill="#A0E3FE"></circle>
                        </svg>
                        <?php if(empty($this->categories[0]['name'])) _e("未选择");else _e($this->categories[0]['name']);?>
                    </a>
                    <div class="sc-AxjAm sc-AxirZ kVrFww">
                        <div class="sc-AxjAm sc-AxirZ  IsObJ" >
                            <div class="sc-AxjAm sc-AxirZ dEkSi agree-btn" style="transform: none;" id="agree-btn" data-cid="<?php $this->cid(); ?>">
                                <svg viewBox="0 0 18 18" class="eVjtUm">
                                    <path d="M8.718 15.371l5.077-.842c.821-.174 1.084-.564 1.176-1.422l.526-5.272c.046-.842-.573-1.291-1.573-1.083l-2.82.599.002-1.236c.001-1.127-.033-2.766-.088-2.96-.295-1.01-.926-1.385-1.698-1.02-.245.13-.257.167-.246 1.023a38.303 38.303 0 01-.008 1.524c-.002.14-.002.264-.002.384.006 1.327-.992 2.361-2.935 3.23l2.59 7.075zm-2.008.333L4.256 8.996a30.684 30.684 0 01-1.598.467 1 1 0 00-.541 1.306l1.903 4.597a1 1 0 001.088.604l1.602-.266zm6.803-10.91c2.215-.46 4.103.91 3.978 3.194l-.531 5.325c-.175 1.64-.95 2.79-2.794 3.181l-8.73 1.45a3 3 0 01-3.264-1.813L.27 11.535a3 3 0 012.008-4.05c3.258-.857 4.79-1.794 4.787-2.41a28.244 28.244 0 01.007-.782c.007-.489.008-.751.003-1.109C7.054 1.66 7.294.95 8.42.35c2.038-.965 3.906.147 4.52 2.251.093.327.128.968.15 2.047.003.078.004.157.005.236l.418-.088z"></path>
                                </svg>
                            </div>
                            <span class="cdBzuL agree-num"><?php echo $agree['agree']; ?></span></div>
                        <div class="sc-AxjAm sc-AxirZ  IsObJ" >
                            <div class="sc-AxjAm sc-AxirZ dEkSi comment-btn">
                                <svg viewBox="0 0 18 18" class="eVjtUm">
                                    <path d="M9 18H4a4 4 0 01-4-4V9a9 9 0 119 9zm0-2a7 7 0 10-7-7v5a2 2 0 002 2h5zM6 6h6a1 1 0 010 2H6a1 1 0 110-2zm0 4h6a1 1 0 010 2H6a1 1 0 010-2z"></path>
                                </svg>
                            </div>
                            <span class="cdBzuL comment-num"><?php $this->commentsNum('0', '1', '%d'); ?></span></div>
                        <div class="sc-AxjAm sc-AxirZ  IsObJ" >
                            <div class="sc-AxjAm sc-AxirZ dEkSi share-btn">
                                <svg viewBox="0 0 18 18" class="eVjtUm">
                                    <path d="M14.086 2.5h-1.872a1 1 0 010-2H16A1.5 1.5 0 0117.5 2v3.786a1 1 0 01-2 0V3.914L9.707 9.707a1 1 0 11-1.414-1.414L14.086 2.5zM9 .5a1 1 0 010 2A6.5 6.5 0 1015.5 9a1 1 0 012 0A8.5 8.5 0 119 .5z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="article-list-plane flex-gird">
                    <div class="col-4">
                        <?php thePrev($this); ?>
                    </div>
                    <div class="col-4">
                        <div class="button" id="article-list-btn">
                            <div class="label">查看目录</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <?php theNext($this); ?>
                    </div>
                </div>
            </article>
            <div style="width:100%;overflow:hidden;max-height: 90px;"><?php _e($this->options->article_bottom_ads);?></div>

                <!--            目录树-->
            <section class="col-12 col-md-4 col-xl-3 article-catalog animate__animated animate__bounceInRight" id="tocTree">
                <h3 class="article-catalog-title">
                    <?php _e('目录'); ?>
                    <button type="button" class="close" aria-label="Close" id="catalog-close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h3>
                <div class="article-list-title">来自 《<?php $this->title() ?>》</div>
                <ul class="article-catalog-list">
                </ul>
            </section>
            <?php $this->need('includes/comments.php'); ?>

        </div>
    </div>
    <?php $this->need('includes/right.php'); ?>
    <!-- Modal -->
    <div class="modal fade" id="repostModal" tabindex="-1" aria-labelledby="repostModalLabel" data-backdrop="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="repostModalLabel">转发：</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-sm">评论:</span>
                        </div>
                        <input type="text" id="repostComment" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm"
                               value='<a href="<?php $this->author->permalink(); ?>">@<?php $this->author(); ?></a>:<?php $this->excerpt(10);?>'
                            data-username="<?php $this->author() ?>" data-excerpt="<?php $this->excerpt(70);?>" data-category='<?$this->category(' ')?>'
                        data-posthref="<?php $this->permalink();?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-outline-info btn-sm" id="repostBtn">转发</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->need('includes/body-layout-end.php');?>

<?php $this->need('includes/footer.php'); ?>
