import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../wayfinder'
/**
* @see \Livewire\Features\SupportFileUploads\FileUploadController::handle
* @see vendor/livewire/livewire/src/Features/SupportFileUploads/FileUploadController.php:27
* @route '/livewire-d1d31633/upload-file'
*/
export const handle = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: handle.url(options),
    method: 'post',
})

handle.definition = {
    methods: ["post"],
    url: '/livewire-d1d31633/upload-file',
} satisfies RouteDefinition<["post"]>

/**
* @see \Livewire\Features\SupportFileUploads\FileUploadController::handle
* @see vendor/livewire/livewire/src/Features/SupportFileUploads/FileUploadController.php:27
* @route '/livewire-d1d31633/upload-file'
*/
handle.url = (options?: RouteQueryOptions) => {
    return handle.definition.url + queryParams(options)
}

/**
* @see \Livewire\Features\SupportFileUploads\FileUploadController::handle
* @see vendor/livewire/livewire/src/Features/SupportFileUploads/FileUploadController.php:27
* @route '/livewire-d1d31633/upload-file'
*/
handle.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: handle.url(options),
    method: 'post',
})

const FileUploadController = { handle }

export default FileUploadController