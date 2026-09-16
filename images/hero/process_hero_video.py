import subprocess
import numpy as np
import scipy.ndimage as ndi
from PIL import Image

def process_video():
    input_file = 'images/hero/ganti_backgroundnya_menjadi_gr.mp4'
    output_webm = 'images/hero/hero_character_transparent.webm'
    output_poster = 'images/hero/hero_character_poster.webp'
    output_anim_webp = 'images/hero/hero_character_anim.webp'
    
    width = 720
    height = 1280
    fps = 24
    frame_size = width * height * 3 # RGB24
    
    # Start ffmpeg input reader process
    cmd_in = [
        'ffmpeg', '-i', input_file,
        '-f', 'image2pipe',
        '-pix_fmt', 'rgb24',
        '-vcodec', 'rawvideo', '-'
    ]
    proc_in = subprocess.Popen(cmd_in, stdout=subprocess.PIPE, stderr=subprocess.DEVNULL)
    
    # Start ffmpeg output writer process for WebM with Alpha (VP9)
    cmd_out = [
        'ffmpeg', '-y',
        '-f', 'rawvideo',
        '-vcodec', 'rawvideo',
        '-s', f'{width}x{height}',
        '-pix_fmt', 'rgba',
        '-r', str(fps),
        '-i', '-',
        '-c:v', 'libvpx-vp9',
        '-pix_fmt', 'yuva420p',
        '-auto-alt-ref', '0',
        '-crf', '26',
        '-b:v', '1500k',
        '-threads', '4',
        output_webm
    ]
    proc_out = subprocess.Popen(cmd_out, stdin=subprocess.PIPE, stderr=subprocess.DEVNULL)
    
    frames_anim = []
    frame_idx = 0
    
    print("Processing video frames with smart chroma key...")
    
    while True:
        raw_frame = proc_in.stdout.read(frame_size)
        if not raw_frame or len(raw_frame) < frame_size:
            break
            
        arr_rgb = np.frombuffer(raw_frame, dtype=np.uint8).reshape((height, width, 3))
        arr = arr_rgb.astype(np.float32)
        
        r = arr[:, :, 0]
        g = arr[:, :, 1]
        b = arr[:, :, 2]
        
        # Background green detection
        diff_rb = np.abs(r - b)
        green_excess = g - (r + b) / 2.0
        
        # Candidate background mask
        is_candidate_bg = (green_excess > 25) & (diff_rb < 40) & (r < 160) & (g > 115) & (b > 60)
        
        # Bottom right watermark area
        is_candidate_bg[int(height * 0.93):, int(width * 0.75):] = True
        # Top 10px edge
        is_candidate_bg[:10, :] = True
        
        # Connected to outer border only (prevents accidental keying inside the character)
        labeled, num_features = ndi.label(is_candidate_bg)
        border_labels = set(np.unique(labeled[0, :])) | set(np.unique(labeled[-1, :])) | set(np.unique(labeled[:, 0])) | set(np.unique(labeled[:, -1]))
        border_labels.discard(0)
        
        is_bg = np.isin(labeled, list(border_labels))
        
        # Dilate 2px to remove edge green fringe
        is_bg_dilated = ndi.binary_dilation(is_bg, iterations=2)
        
        # Smooth alpha mask
        alpha_float = np.where(is_bg_dilated, 0.0, 1.0)
        alpha_smooth = ndi.gaussian_filter(alpha_float, sigma=1.0)
        alpha_smooth = np.clip(alpha_smooth, 0.0, 1.0)
        
        # Despill on edges
        fg_edge = (alpha_smooth > 0.01) & (alpha_smooth < 0.99)
        g_excess_fg = np.maximum(0.0, g - np.maximum(r, b))
        
        arr_cleaned = arr.copy()
        arr_cleaned[:, :, 1] = np.where(fg_edge, g - 0.8 * g_excess_fg, g)
        
        # Construct RGBA
        rgba = np.zeros((height, width, 4), dtype=np.uint8)
        rgba[:, :, 0] = np.clip(arr_cleaned[:, :, 0] * alpha_smooth, 0, 255).astype(np.uint8)
        rgba[:, :, 1] = np.clip(arr_cleaned[:, :, 1] * alpha_smooth, 0, 255).astype(np.uint8)
        rgba[:, :, 2] = np.clip(arr_cleaned[:, :, 2] * alpha_smooth, 0, 255).astype(np.uint8)
        rgba[:, :, 3] = (alpha_smooth * 255).astype(np.uint8)
        
        # Write to WebM pipe
        proc_out.stdin.write(rgba.tobytes())
        
        # Save poster from frame 0
        if frame_idx == 0:
            poster_img = Image.fromarray(rgba, 'RGBA')
            poster_img.save(output_poster, 'WEBP', quality=95)
            poster_img.save('images/hero/hero_character_poster.png', 'PNG')
            
        frame_idx += 1
        if frame_idx % 24 == 0:
            print(f"Processed {frame_idx} frames ({frame_idx // 24}s)...")
            
    proc_in.stdout.close()
    proc_in.wait()
    proc_out.stdin.close()
    proc_out.wait()
    
    print(f"Finished processing {frame_idx} frames. Output saved to {output_webm} and {output_poster}")

if __name__ == '__main__':
    process_video()
