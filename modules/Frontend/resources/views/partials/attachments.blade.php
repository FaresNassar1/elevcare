@if (!empty($fileTypes))
<div class="file-attachs">
            <h4 class="sub-title">{{ __('Attachments') }}</h4>
                <div class="files-list">
                    @if (isset($fileTypes['audio']))
                        @foreach ($fileTypes['audio'] as $file)
                                <div class="download-item">
                                        <a href="{{ Storage::url($file->path) }}" data-fancybox data-type="html5video"
                                            title="{{ $file->name }}"><i class="far fa-file-audio"></i>
                                        {{ $file->name }}</a>
                                </div>
                        @endforeach
                    @endif
                    @if (isset($fileTypes['file']))
                        @foreach ($fileTypes['file'] as $file)
                                <div class="download-item">
                                <a href="{{ Storage::url($file->path) }}" data-fancybox
                                                title="{{ $file->name }}" target="_blank"><i class="fas fa-file-alt"></i> {{ $file->name }}</a>

                                </div>
                        @endforeach
                    @endif

                    @if (isset($fileTypes['url']))
                        @foreach ($fileTypes['url'] as $file)
                                <div class="download-item">
                                            <a href="{{ $file->path }}" data-fancybox  title="{{ $file->name }}"
                                                download=""><i class="fas fa-file-video"></i>{{ $file->name }}</a>
                                </div>
                        @endforeach
                    @endif

                    @if (isset($fileTypes['video']))
                        @foreach ($fileTypes['video'] as $file)
                                <div class="download-item">
                                            <a href="{{ Storage::url($file->path) }}" data-fancybox
                                                title="{{ $file->name }}" download=""><i class="fas fa-file-video"></i>{{ $file->name }}</a>
                                </div>
                        @endforeach
                    @endif

                </div>
            </div>
@endif
