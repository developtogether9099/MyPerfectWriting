

<?php $__env->startSection('css'); ?>
	<!-- RichText CSS -->
	<link href="<?php echo e(URL::asset('plugins/richtext/richtext.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header'); ?>
	<!-- PAGE HEADER -->
	<div class="page-header mt-5-7">
		<div class="page-leftheader">
			<h4 class="page-title mb-0"><?php echo e(__('Edit Blog Post')); ?></h4>
	
		</div>
	</div>
	<!-- END PAGE HEADER -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>						
	<!-- SUPPORT REQUEST -->
	<div class="row">
		<div class="col-lg-8 col-md-8 col-xm-12">
			<div class="card overflow-hidden border-0">
				<div class="card-header">
					<h3 class="card-title"><?php echo e(__('Edit Blog Post')); ?></h3>
				</div>
				<div class="card-body pt-5">									
					<form id="" action="<?php echo e(route('blogger.blog.update', [$id->id])); ?>" method="POST" enctype="multipart/form-data">
						<?php echo method_field('PUT'); ?>
						<?php echo csrf_field(); ?>

						<div class="row mt-2">							
							<div class="col-lg-12 col-md-12 col-sm-12">							
								<div class="input-box">								
									<h6><?php echo e(__('Blog Title')); ?> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
									<div class="form-group">							    
										<input type="text" class="form-control" id="title" name="title" value="<?php echo e($id->title); ?>" required>
									</div> 
									<?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
										<p class="text-danger"><?php echo e($errors->first('title')); ?></p>
									<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>	
								</div> 						
							</div>

							<div class="col-lg-12 col-md-12 col-sm-12">							
								<div class="input-box">								
									<h6><?php echo e(__('SEO Keywords')); ?> <span class="text-muted">(<?php echo e(__('Optional, Comman Seperated')); ?>)</span></h6>
									<div class="form-group">							    
										<input type="text" class="form-control" id="keywords" name="keywords" value="<?php echo e($id->keywords); ?>">
									</div> 
									<?php $__errorArgs = ['keywords'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
										<p class="text-danger"><?php echo e($errors->first('keywords')); ?></p>
									<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>	
								</div> 						
							</div>

							<div class="col-lg-12 col-md-12 col-sm-12">							
								<div class="input-box">								
									<h6><?php echo e(__('Custom SEO URL')); ?> <span class="text-muted">(<?php echo e(__('Optional')); ?>)</span></h6>
									<div class="form-group">							    
										<input type="text" class="form-control" id="url" name="url" value="<?php echo e($id->url); ?>">
									</div> 
									<?php $__errorArgs = ['url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
										<p class="text-danger"><?php echo e($errors->first('url')); ?></p>
									<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>	
								</div> 						
							</div>

							<div class="col-lg-6 col-md-6 col-sm-12">							
								<div class="input-box">	
									<h6><?php echo e(__('Blog Status')); ?> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
			  						<select id="smtp-encryption" name="status" data-placeholder="Blog Status:">			
										<option value="published" <?php if($id->status == 'published'): ?> selected <?php endif; ?>><?php echo e(__('Publish')); ?></option>
										<option value="hidden" <?php if($id->status == 'hidden'): ?> selected <?php endif; ?>><?php echo e(__('Hide')); ?></option>
									</select>
								</div> 							
							</div>

							<div class="col-lg-6 col-md-6 col-sm-12">
								<div class="input-box">
									<h6><?php echo e(__('Blog Image')); ?></h6>
									<div class="input-group file-browser">									
										<input type="text" class="form-control border-right-0 browse-file" placeholder="Image File Name" readonly>
										<label class="input-group-btn">
											<span class="btn btn-primary special-btn">
												<?php echo e(__('Browse')); ?> <input type="file" name="image" style="display: none;">
											</span>
										</label>
									</div>
									<?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
										<p class="text-danger"><?php echo e($errors->first('image')); ?></p>
									<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
								</div>
							</div>
						</div>

						<div class="row mt-2">
							<div class="col-lg-12 col-md-12 col-sm-12">	
								<div class="input-box">	
									<h6><?php echo e(__('Blog Post Content')); ?> <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>							
									<textarea class="form-control" name="content" rows="12" id="richtext" required><?php echo e($id->body); ?></textarea>
									<?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
										<p class="text-danger"><?php echo e($errors->first('content')); ?></p>
									<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>	
								</div>											
							</div>
						</div>

						<!-- ACTION BUTTON -->
						<div class="border-0 text-right mb-2 mt-1">
							<a href="<?php echo e(route('admin.settings.blog')); ?>" class="btn btn-cancel mr-2"><?php echo e(__('Cancel')); ?></a>
							<button type="submit" class="btn btn-primary"><?php echo e(__('Update')); ?></button>							
						</div>				

					</form>					
				</div>
			</div>
		</div>
	</div>
	<!-- END SUPPORT REQUEST -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
	<!-- File Uploader -->
	<script src="<?php echo e(URL::asset('js/file-upload.js')); ?>"></script>
	<!-- RichText JS -->
	<script src="<?php echo e(URL::asset('plugins/richtext/jquery.richtext.min.js')); ?>"></script>
	<script type="text/javascript">
		$(function () {

			"use strict";

			$('#richtext').richText({

				// text formatting
				bold: true,
				italic: true,
				underline: true,

				// text alignment
				leftAlign: true,
				centerAlign: true,
				rightAlign: true,
				justify: true,

				// lists
				ol: true,
				ul: true,

				// title
				heading: true,

				// fonts
				fonts: true,
				fontList: [
					"Arial", 
					"Arial Black", 
					"Comic Sans MS", 
					"Courier New", 
					"Geneva", 
					"Georgia", 
					"Helvetica", 
					"Impact", 
					"Lucida Console", 
					"Tahoma", 
					"Times New Roman",
					"Verdana"
				],
				fontColor: true,
				fontSize: true,

				// uploads
				imageUpload: true,
				fileUpload: true,

				// media
				videoEmbed: true,

				// link
				urls: true,

				// tables
				table: true,

				// code
				removeStyles: true,
				code: true,

				// colors
				colors: [],

				// dropdowns
				fileHTML: '',
				imageHTML: '',

				// translations
				translations: {
					'title': 'Title',
					'white': 'White',
					'black': 'Black',
					'brown': 'Brown',
					'beige': 'Beige',
					'darkBlue': 'Dark Blue',
					'blue': 'Blue',
					'lightBlue': 'Light Blue',
					'darkRed': 'Dark Red',
					'red': 'Red',
					'darkGreen': 'Dark Green',
					'green': 'Green',
					'purple': 'Purple',
					'darkTurquois': 'Dark Turquois',
					'turquois': 'Turquois',
					'darkOrange': 'Dark Orange',
					'orange': 'Orange',
					'yellow': 'Yellow',
					'imageURL': 'Image URL',
					'fileURL': 'File URL',
					'linkText': 'Link text',
					'url': 'URL',
					'size': 'Size',
					'responsive': 'Responsive',
					'text': 'Text',
					'openIn': 'Open in',
					'sameTab': 'Same tab',
					'newTab': 'New tab',
					'align': 'Align',
					'left': 'Left',
					'center': 'Center',
					'right': 'Right',
					'rows': 'Rows',
					'columns': 'Columns',
					'add': 'Add',
					'pleaseEnterURL': 'Please enter an URL',
					'videoURLnotSupported': 'Video URL not supported',
					'pleaseSelectImage': 'Please select an image',
					'pleaseSelectFile': 'Please select a file',
					'bold': 'Bold',
					'italic': 'Italic',
					'underline': 'Underline',
					'alignLeft': 'Align left',
					'alignCenter': 'Align centered',
					'alignRight': 'Align right',
					'addOrderedList': 'Add ordered list',
					'addUnorderedList': 'Add unordered list',
					'addHeading': 'Add Heading/title',
					'addFont': 'Add font',
					'addFontColor': 'Add font color',
					'addFontSize' : 'Add font size',
					'addImage': 'Add image',
					'addVideo': 'Add video',
					'addFile': 'Add file',
					'addURL': 'Add URL',
					'addTable': 'Add table',
					'removeStyles': 'Remove styles',
					'code': 'Show HTML code',
					'undo': 'Undo',
					'redo': 'Redo',
					'close': 'Close'
				},
						
				// privacy
				youtubeCookies: false,

				// developer settings
				useSingleQuotes: false,
				height: 0,
				heightPercentage: 0,
				id: "",
				class: "",
				useParagraph: false,
				maxlength: 0,
				callback: undefined,
				useTabForNext: false
			});

		});
	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/vhosts/myperfectwriting.co.uk/httpdocs/resources/views/blogger/blogs/edit.blade.php ENDPATH**/ ?>